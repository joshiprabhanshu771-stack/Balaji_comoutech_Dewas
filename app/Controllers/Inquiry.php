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
            'name'    => 'required|min_length[3]|max_length[100]',
            'email'   => 'required|valid_email',
            'mobile'  => 'required|min_length[10]|max_length[15]',
            'message' => 'required|min_length[5]',
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
            'name'         => trim($this->request->getPost('name')),
            'email'        => trim($this->request->getPost('email')),
            'mobile'       => trim($this->request->getPost('mobile')),
            'subject'      => trim($this->request->getPost('subject') ?? 'Product/Service Inquiry'),
            'message'      => trim($this->request->getPost('message')),
            'inquiry_type' => $inquiryType,
            'status'       => 'pending',
        ];

        $inquiryId = $inquiryModel->insert($data);
        $data['id'] = $inquiryId;

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
            $adminEmail = get_setting('contact_email', 'info@balajicomputech.com');
            $email->setTo($adminEmail);
            $email->setFrom($data['email'], $data['name']);
            $email->setSubject("New Inquiry [{$inquiryNo}]: {$data['subject']}");
            $email->setMessage("New customer inquiry received:\n\nInquiry No: {$inquiryNo}\nName: {$data['name']}\nMobile: {$data['mobile']}\nEmail: {$data['email']}\n\nMessage:\n{$data['message']}");
            // Non-blocking attempt
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
