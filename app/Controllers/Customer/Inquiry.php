<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\InquiryModel;
use App\Models\InquiryReplyModel;

class Inquiry extends BaseController
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
        $userId = session()->get('user_id');
        $status = $this->request->getGet('status');

        $filters = ['user_id' => $userId];
        if (!empty($status)) {
            $filters['status'] = $status;
        }

        $inquiries = $this->inquiryModel->getInquiriesWithDetails($filters);

        return view('customer/inquiries', [
            'page_title' => 'My Product & Service Inquiries | Balaji Computech',
            'inquiries'  => $inquiries,
            'currentStatus' => $status,
        ]);
    }

    public function detail($id)
    {
        $userId = session()->get('user_id');
        $inquiry = $this->inquiryModel->getInquiryDetail($id);

        if (!$inquiry || (int)$inquiry['user_id'] !== (int)$userId) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Inquiry record not found.');
        }

        $replies = $this->replyModel->getRepliesWithUser($id);

        return view('customer/inquiry_detail', [
            'page_title' => "Inquiry #{$inquiry['inquiry_no']} | Balaji Computech",
            'inquiry'    => $inquiry,
            'replies'    => $replies,
        ]);
    }
}
