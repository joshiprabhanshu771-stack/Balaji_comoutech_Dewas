<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\InquiryModel;
use App\Models\InquiryReplyModel;

class InquiryController extends BaseController
{
    protected $inquiryModel;
    protected $replyModel;

    public function __construct()
    {
        $this->inquiryModel = new InquiryModel();
        $this->replyModel   = new InquiryReplyModel();
    }

    public function index()
    {
        $status = $this->request->getGet('status');
        $type   = $this->request->getGet('type');
        $search = $this->request->getGet('q');

        $filters = [];
        if (!empty($status)) {
            $filters['status'] = $status;
        }
        if (!empty($type)) {
            $filters['inquiry_type'] = $type;
        }
        if (!empty($search)) {
            $filters['search'] = $search;
        }

        $inquiries = $this->inquiryModel->getInquiriesWithDetails($filters, 30);

        return view('admin/inquiries/index', [
            'page_title' => 'Inquiry Management | Admin',
            'inquiries'  => $inquiries,
            'status'     => $status,
            'type'       => $type,
            'search'     => $search,
        ]);
    }

    public function detail($id)
    {
        $inquiry = $this->inquiryModel->getInquiryDetail($id);
        if (!$inquiry) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Inquiry not found.');
        }

        $replies = $this->replyModel->getRepliesWithUser($id);

        return view('admin/inquiries/detail', [
            'page_title' => 'Inquiry #' . esc($inquiry['inquiry_no']),
            'inquiry'    => $inquiry,
            'replies'    => $replies,
        ]);
    }

    public function reply($id)
    {
        $inquiry = $this->inquiryModel->find($id);
        if (!$inquiry) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Inquiry not found.');
        }

        $message = trim($this->request->getPost('message') ?? '');
        if (empty($message)) {
            return redirect()->back()->with('error', 'Reply message cannot be empty.');
        }

        $sendEmail = $this->request->getPost('send_email') ? 1 : 0;
        $adminId   = session()->get('user_id');

        $replyId = $this->replyModel->insert([
            'inquiry_id' => $id,
            'user_id'    => $adminId,
            'message'    => $message,
            'sent_email' => $sendEmail,
        ]);

        // Automatically update inquiry status to 'replied'
        $this->inquiryModel->update($id, ['status' => 'replied']);

        if ($sendEmail) {
            try {
                $email = \Config\Services::email();
                $email->setTo($inquiry['email']);
                $email->setFrom(get_setting('contact_email', 'info@balajicomputech.com'), get_setting('site_name', 'Balaji Computech'));
                $email->setSubject("Response to your Inquiry [{$inquiry['inquiry_no']}] - Balaji Computech");
                $email->setMessage("Hello {$inquiry['name']},\n\nThank you for contacting Balaji Computech.\n\nHere is our response regarding inquiry #{$inquiry['inquiry_no']}:\n\n{$message}\n\nFeel free to contact Gourav Joshi directly at " . get_setting('contact_phone', '+91 98260 12345') . " or visit our store at " . get_setting('shop_address') . ".\n\nBest Regards,\nBalaji Computech Team");
                @$email->send(false);
            } catch (\Throwable $e) {
                log_message('error', 'Inquiry reply email error: ' . $e->getMessage());
            }
        }

        // Attempt Firebase Push Notification to Customer (failsafe)
        try {
            $firebaseService = new \App\Libraries\FirebaseNotificationService();
            $replyData = [
                'id'         => $replyId,
                'inquiry_id' => $id,
                'user_id'    => $adminId,
                'message'    => $message,
            ];
            $firebaseService->notifyCustomerOnInquiryReply($inquiry, $replyData);
        } catch (\Throwable $e) {
            log_message('error', 'Inquiry reply push notification to customer failed: ' . $e->getMessage());
        }

        return redirect()->to(base_url("admin/inquiries/{$id}"))->with('success', 'Reply posted and customer updated successfully.');
    }

    public function updateStatus($id)
    {
        $inquiry = $this->inquiryModel->find($id);
        if (!$inquiry) {
            return redirect()->back()->with('error', 'Inquiry not found.');
        }

        $status = $this->request->getPost('status');
        $notes  = $this->request->getPost('admin_notes');

        $this->inquiryModel->update($id, [
            'status'      => $status,
            'admin_notes' => $notes,
        ]);

        return redirect()->back()->with('success', 'Inquiry status updated successfully.');
    }

    public function delete($id)
    {
        $inquiry = $this->inquiryModel->find($id);
        if ($inquiry) {
            $this->inquiryModel->delete($id);
            return redirect()->to(base_url('admin/inquiries'))->with('success', 'Inquiry deleted successfully.');
        }
        return redirect()->to(base_url('admin/inquiries'))->with('error', 'Inquiry not found.');
    }
}
