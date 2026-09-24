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
        $messages = $this->contactModel->orderBy('id', 'DESC')->findAll();

        return view('admin/contact/index', [
            'page_title' => 'Contact Form Messages | Admin',
            'messages'   => $messages,
        ]);
    }

    public function detail($id)
    {
        $message = $this->contactModel->find($id);
        if (!$message) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Message not found.');
        }

        // Mark as read
        if (!$message['is_read']) {
            $this->contactModel->update($id, ['is_read' => 1]);
        }

        return view('admin/contact/detail', [
            'page_title' => 'Message from ' . esc($message['name']),
            'message'    => $message,
        ]);
    }

    public function delete($id)
    {
        $message = $this->contactModel->find($id);
        if ($message) {
            $this->contactModel->delete($id);
            return redirect()->to(base_url('admin/contact-messages'))->with('success', 'Message deleted successfully.');
        }
        return redirect()->to(base_url('admin/contact-messages'))->with('error', 'Message not found.');
    }
}
