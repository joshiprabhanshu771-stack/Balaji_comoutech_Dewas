<?php

namespace App\Controllers;

use App\Models\InquiryModel;
use App\Models\ProductModel;
use App\Models\ServiceModel;

class Inquiry extends BaseController
{
    public function submit()
    {
        $rules = [
            'name'    => [
                'rules'  => 'required|min_length[2]|max_length[100]',
                'errors' => [
                    'required' => 'Please enter your name.',
                ],
            ],
            'email'   => [
                'rules'  => 'required|valid_email|max_length[150]',
                'errors' => [
                    'required'    => 'Please enter your email address.',
                    'valid_email' => 'Please enter a valid email address.',
                ],
            ],
            'mobile'  => [
                'rules'  => 'required|indian_mobile',
                'errors' => [
                    'required'      => 'Please enter your mobile number.',
                    'indian_mobile' => 'Please enter a valid 10-digit Indian mobile number (e.g. 9876543210 or +919876543210).',
                ],
            ],
            'message' => [
                'rules'  => 'required|min_length[5]|max_length[5000]',
                'errors' => [
                    'required'   => 'Please provide your inquiry requirement details.',
                    'min_length' => 'Message must be at least 5 characters long.',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $this->validator->getErrors(),
                ]);
            }
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $rawMobile = (string)$this->request->getPost('mobile');
        $normalizedMobile = normalize_indian_mobile($rawMobile);

        if (!$normalizedMobile) {
            $errorMsg = 'Please enter a valid 10-digit Indian mobile number (e.g. 9876543210 or +919876543210).';
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => ['mobile' => $errorMsg],
                ]);
            }
            return redirect()->back()->withInput()->with('errors', ['mobile' => $errorMsg]);
        }

        $inquiryModel = new InquiryModel();
        $inquiryNo    = $inquiryModel->generateInquiryNumber();

        $userId      = session()->get('isLoggedIn') ? session()->get('user_id') : null;
        $productId   = $this->request->getPost('product_id') ? (int)$this->request->getPost('product_id') : null;
        $serviceId   = $this->request->getPost('service_id') ? (int)$this->request->getPost('service_id') : null;
        $inquiryType = $this->request->getPost('inquiry_type') ?? ($productId ? 'product' : ($serviceId ? 'service' : 'general'));

        $data = [
            'inquiry_no'   => $inquiryNo,
            'user_id'      => $userId,
            'product_id'   => $productId,
            'service_id'   => $serviceId,
            'name'         => trim((string)$this->request->getPost('name')),
            'email'        => strtolower(trim((string)$this->request->getPost('email'))),
            'mobile'       => $normalizedMobile,
            'subject'      => trim((string)($this->request->getPost('subject') ?? 'Product/Service Inquiry')),
            'message'      => trim((string)$this->request->getPost('message')),
            'inquiry_type' => $inquiryType,
            'status'       => 'pending',
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ];

        try {
            $inquiryId = $inquiryModel->insert($data);
            $data['id'] = $inquiryId;
        } catch (\Throwable $e) {
            log_message('error', 'Inquiry::submit database error: ' . $e->getMessage());
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Unable to process your inquiry right now. Please call or WhatsApp us.',
                ]);
            }
            return redirect()->back()->withInput()->with('error', 'Unable to submit your inquiry at this time.');
        }

        // Determine item name for notifications
        $itemName = null;
        if ($productId) {
            $productModel = new ProductModel();
            $product = $productModel->find($productId);
            if ($product) {
                $itemName = $product['name'];
            }
        } elseif ($serviceId) {
            $serviceModel = new ServiceModel();
            $service = $serviceModel->find($serviceId);
            if ($service) {
                $itemName = $service['name'];
            }
        }

        // Attempt Email Notification (failsafe)
        try {
            $email = \Config\Services::email();
            $adminEmail = (string)get_setting('contact_email', 'info@balajicomputech.com');
            $email->setTo($adminEmail);
            $email->setFrom($data['email'], $data['name']);
            $email->setSubject("New Inquiry [{$inquiryNo}]: {$data['subject']}");
            $email->setMessage("New customer inquiry received:\n\nInquiry No: {$inquiryNo}\nName: {$data['name']}\nMobile: {$data['mobile']}\nEmail: {$data['email']}\n\nMessage:\n{$data['message']}");
            @$email->send(false);
        } catch (\Throwable $e) {
            log_message('error', 'Inquiry email notification failed: ' . $e->getMessage());
        }

        // Attempt Firebase Push Notification to all active Admins (failsafe)
        try {
            $firebaseService = new \App\Libraries\FirebaseNotificationService();
            $firebaseService->notifyAdminsOnNewInquiry($data, $itemName);
        } catch (\Throwable $e) {
            log_message('error', 'Inquiry push notification to admins failed: ' . $e->getMessage());
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status'     => 'success',
                'inquiry_no' => $inquiryNo,
                'message'    => "Your inquiry ({$inquiryNo}) has been submitted successfully! Gourav Joshi and our team will get back to you promptly.",
            ]);
        }

        return redirect()->back()->with('success', "Your inquiry ({$inquiryNo}) has been submitted successfully! We will contact you soon.");
    }
}
