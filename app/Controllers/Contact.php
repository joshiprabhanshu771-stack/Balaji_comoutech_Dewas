<?php

namespace App\Controllers;

use App\Models\ContactMessageModel;
use App\Models\PresenceModel;

class Contact extends BaseController
{
    public function index()
    {
        try {
            $presenceModel = new PresenceModel();
            $primaryLocation = $presenceModel->getPrimaryLocation();
        } catch (\Throwable $e) {
            log_message('error', 'Contact::index error: ' . $e->getMessage());
            $primaryLocation = null;
        }

        return view('contact', [
            'page_title'      => 'Contact Us & Shop Location | Balaji Computech Dewas',
            'primaryLocation' => $primaryLocation,
        ]);
    }

    public function submit()
    {
        $rules = [
            'name'    => [
                'rules'  => 'required|min_length[2]|max_length[100]',
                'errors' => [
                    'required'   => 'Please enter your name.',
                    'min_length' => 'Name must be at least 2 characters long.',
                    'max_length' => 'Name cannot exceed 100 characters.',
                ],
            ],
            'email'   => [
                'rules'  => 'required|valid_email|max_length[150]',
                'errors' => [
                    'required'    => 'Please enter your email address.',
                    'valid_email' => 'Please enter a valid email address (e.g. rahul@gmail.com).',
                    'max_length'  => 'Email cannot exceed 150 characters.',
                ],
            ],
            'mobile'  => [
                'rules'  => 'required|indian_mobile',
                'errors' => [
                    'required'      => 'Please enter your mobile number.',
                    'indian_mobile' => 'Please enter a valid 10-digit Indian mobile number (e.g. 9876543210 or +919876543210).',
                ],
            ],
            'subject' => [
                'rules'  => 'required|min_length[2]|max_length[200]',
                'errors' => [
                    'required'   => 'Please enter a subject for your message.',
                    'min_length' => 'Subject must be at least 2 characters long.',
                    'max_length' => 'Subject cannot exceed 200 characters.',
                ],
            ],
            'message' => [
                'rules'  => 'required|min_length[5]|max_length[5000]',
                'errors' => [
                    'required'   => 'Please enter your message or requirement details.',
                    'min_length' => 'Message must be at least 5 characters long.',
                    'max_length' => 'Message cannot exceed 5000 characters.',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $rawMobile = $this->request->getPost('mobile');
        $normalizedMobile = normalize_indian_mobile($rawMobile);

        if (!$normalizedMobile) {
            return redirect()->back()->withInput()->with('errors', [
                'mobile' => 'Please enter a valid 10-digit Indian mobile number (e.g. 9876543210 or +919876543210).',
            ]);
        }

        $email       = strtolower(trim((string)$this->request->getPost('email')));
        $name        = trim((string)$this->request->getPost('name'));
        $subject     = trim((string)$this->request->getPost('subject'));
        $messageText = trim((string)$this->request->getPost('message'));

        try {
            $contactModel = new ContactMessageModel();
            $data = [
                'name'       => $name,
                'email'      => $email,
                'mobile'     => $normalizedMobile,
                'subject'    => $subject,
                'message'    => $messageText,
                'is_read'    => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $saved = $contactModel->insert($data);

            if ($saved) {
                // Attempt admin email notification safely (non-blocking)
                try {
                    $adminEmail = (string)get_setting('contact_email', 'info@balajicomputech.com');
                    $mailer = \Config\Services::email();
                    $mailer->setTo($adminEmail);
                    $mailer->setFrom($email, $name);
                    $mailer->setSubject("New Contact Form Message from {$name}: {$subject}");
                    $mailer->setMessage("New message received on Balaji Computech website:\n\nName: {$name}\nMobile: {$normalizedMobile}\nEmail: {$email}\nSubject: {$subject}\n\nMessage:\n{$messageText}\n\nDate: " . date('d M Y, h:i A'));
                    @$mailer->send(false);
                } catch (\Throwable $mailEx) {
                    log_message('error', 'Contact form mail notification error: ' . $mailEx->getMessage());
                }

                return redirect()->to(base_url('contact'))->with('success', 'Thank you, ' . esc($name) . '! Your message has been sent successfully. Gourav Joshi and our team will get in touch with you shortly.');
            }
        } catch (\Throwable $e) {
            log_message('error', 'Contact form submission exception: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
        }

        return redirect()->back()->withInput()->with('error', 'Unable to submit your message at this time. Please try calling us directly or messaging via WhatsApp.');
    }
}
