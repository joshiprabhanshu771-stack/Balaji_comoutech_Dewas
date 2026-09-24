<?php

namespace App\Controllers;

use App\Models\ContactMessageModel;
use App\Models\PresenceModel;

class Contact extends BaseController
{
    public function index()
    {
        $presenceModel = new PresenceModel();
        $primaryLocation = $presenceModel->getPrimaryLocation();

        return view('contact', [
            'page_title'      => 'Contact Us & Shop Location | Balaji Computech Dewas',
            'primaryLocation' => $primaryLocation,
        ]);
    }

    public function submit()
    {
        $rules = [
            'name'    => 'required|min_length[3]|max_length[100]',
            'email'   => 'required|valid_email',
            'mobile'  => 'required|min_length[10]|max_length[15]',
            'subject' => 'required|min_length[3]|max_length[200]',
            'message' => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $contactModel = new ContactMessageModel();
        $saved = $contactModel->insert([
            'name'    => trim($this->request->getPost('name')),
            'email'   => trim($this->request->getPost('email')),
            'mobile'  => trim($this->request->getPost('mobile')),
            'subject' => trim($this->request->getPost('subject')),
            'message' => trim($this->request->getPost('message')),
            'is_read' => 0,
        ]);

        if ($saved) {
            return redirect()->to(base_url('contact'))->with('success', 'Thank you! Your message has been sent successfully. Gourav Joshi and our team will get in touch with you shortly.');
        }

        return redirect()->back()->withInput()->with('error', 'Unable to submit your message at this time. Please try calling us directly or via WhatsApp.');
    }
}
