<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PresenceModel;

class PresenceController extends BaseController
{
    protected $presenceModel;

    public function __construct()
    {
        $this->presenceModel = new PresenceModel();
    }

    public function index()
    {
        $locations = $this->presenceModel->findAll();

        return view('admin/presence/index', [
            'page_title' => 'Store Presence & Location Management | Admin',
            'locations'  => $locations,
        ]);
    }

    public function edit($id)
    {
        $location = $this->presenceModel->find($id);
        if (!$location) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Location not found.');
        }

        return view('admin/presence/edit', [
            'page_title' => 'Edit Store Location | Admin',
            'location'   => $location,
        ]);
    }

    public function update($id)
    {
        $location = $this->presenceModel->find($id);
        if (!$location) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Location not found.');
        }

        $rules = [
            'title'         => 'required|min_length[3]|max_length[150]',
            'address_line1' => 'required|min_length[5]|max_length[255]',
            'city'          => 'required|max_length[100]',
            'phone'         => 'required|max_length[30]',
            'email'         => 'required|valid_email',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->presenceModel->update($id, [
            'title'             => trim($this->request->getPost('title')),
            'address_line1'     => trim($this->request->getPost('address_line1')),
            'address_line2'     => trim($this->request->getPost('address_line2') ?? ''),
            'city'              => trim($this->request->getPost('city')),
            'state'             => trim($this->request->getPost('state')),
            'pincode'           => trim($this->request->getPost('pincode')),
            'phone'             => trim($this->request->getPost('phone')),
            'alternate_phone'   => trim($this->request->getPost('alternate_phone') ?? ''),
            'email'             => trim($this->request->getPost('email')),
            'landmark'          => trim($this->request->getPost('landmark') ?? ''),
            'google_maps_embed' => $this->request->getPost('google_maps_embed'),
            'google_maps_link'  => trim($this->request->getPost('google_maps_link') ?? ''),
            'opening_hours'     => trim($this->request->getPost('opening_hours')),
            'is_primary'        => $this->request->getPost('is_primary') ? 1 : 0,
        ]);

        return redirect()->to(base_url('admin/presence'))->with('success', 'Store presence details updated successfully!');
    }
}
