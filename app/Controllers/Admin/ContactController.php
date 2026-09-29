<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ContactMessageModel;

class ContactController extends BaseController
{
    protected $contactModel;

    public function __construct()
    {
        $this->contactModel = new ContactMessageModel();
    }

    public function index()
    {
        try {
            $messages = $this->contactModel->orderBy('id', 'DESC')->findAll();
        } catch (\Throwable $e) {
            log_message('error', 'ContactController::index database error: ' . $e->getMessage());
            $messages = [];
        }

        return view('admin/contact/index', [
            'page_title' => 'Contact Form Messages | Admin',
            'messages'   => $messages,
        ]);
    }

    public function detail($id = null)
    {
        // 1. Validate ID parameter safely
        if ($id === null || !is_numeric($id) || (int)$id <= 0) {
            return redirect()->to(base_url('admin/contact-messages'))
                ->with('error', 'Invalid contact message ID specified.');
        }

        $id = (int)$id;

        try {
            // 2. Safely find the message record
            $message = $this->contactModel->find($id);

            if (!$message) {
                return redirect()->to(base_url('admin/contact-messages'))
                    ->with('error', 'The requested contact message was not found or has been removed.');
            }

            // 3. Mark as read safely
            if (empty($message['is_read'])) {
                $this->contactModel->markAsRead($id);
                $message['is_read'] = 1;
            }

            // 4. Return the detail view safely
            return view('admin/contact/detail', [
                'page_title' => 'Message from ' . esc($message['name'] ?? 'Visitor'),
                'message'    => $message,
            ]);

        } catch (\Throwable $e) {
            log_message('error', 'ContactController::detail error for ID ' . $id . ': ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return redirect()->to(base_url('admin/contact-messages'))
                ->with('error', 'An error occurred while loading the contact message. Please check the logs.');
        }
    }

    public function delete($id = null)
    {
        if ($id === null || !is_numeric($id) || (int)$id <= 0) {
            return redirect()->to(base_url('admin/contact-messages'))
                ->with('error', 'Invalid contact message ID.');
        }

        $id = (int)$id;

        try {
            $message = $this->contactModel->find($id);
            if ($message) {
                $this->contactModel->delete($id);
                return redirect()->to(base_url('admin/contact-messages'))
                    ->with('success', 'Contact message deleted successfully.');
            }

            return redirect()->to(base_url('admin/contact-messages'))
                ->with('error', 'Message not found.');
        } catch (\Throwable $e) {
            log_message('error', 'ContactController::delete error for ID ' . $id . ': ' . $e->getMessage());
            return redirect()->to(base_url('admin/contact-messages'))
                ->with('error', 'Unable to delete contact message at this time.');
        }
    }
}
