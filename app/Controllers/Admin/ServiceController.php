<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ServiceModel;

class ServiceController extends BaseController
{
    protected $serviceModel;

    public function __construct()
    {
        $this->serviceModel = new ServiceModel();
    }

    public function index()
    {
        $services = $this->serviceModel->findAll();

        return view('admin/services/index', [
            'page_title' => 'Service Management | Admin',
            'services'   => $services,
        ]);
    }

    public function create()
    {
        return view('admin/services/create', [
            'page_title' => 'Add New Service | Admin',
        ]);
    }

    public function store()
    {
        $rules = [
            'name'           => 'required|min_length[3]|max_length[150]',
            'starting_price' => 'permit_empty|numeric',
            'image'          => 'permit_empty|is_image[image]|max_size[image,3072]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = trim($this->request->getPost('name'));
        $slug = url_title($name, '-', true);

        $existing = $this->serviceModel->where('slug', $slug)->first();
        if ($existing) {
            $slug .= '-' . time();
        }

        $imageName = null;
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName();
            $uploadPath = ROOTPATH . 'public/uploads/services';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $file->move($uploadPath, $imageName);
        }

        $this->serviceModel->insert([
            'name'              => $name,
            'slug'              => $slug,
            'icon'              => trim($this->request->getPost('icon') ?? 'bi bi-tools'),
            'image'             => $imageName,
            'short_description' => trim($this->request->getPost('short_description') ?? ''),
            'full_description'  => $this->request->getPost('full_description'),
            'features'          => trim($this->request->getPost('features') ?? ''),
            'turnaround_time'   => trim($this->request->getPost('turnaround_time') ?? ''),
            'starting_price'    => $this->request->getPost('starting_price') !== '' ? (float)$this->request->getPost('starting_price') : null,
            'is_featured'       => $this->request->getPost('is_featured') ? 1 : 0,
            'status'            => $this->request->getPost('status') ?? 'active',
        ]);

        return redirect()->to(base_url('admin/services'))->with('success', 'Service created successfully!');
    }

    public function edit($id)
    {
        $service = $this->serviceModel->find($id);
        if (!$service) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Service not found.');
        }

        return view('admin/services/edit', [
            'page_title' => 'Edit Service: ' . esc($service['name']),
            'service'    => $service,
        ]);
    }

    public function update($id)
    {
        $service = $this->serviceModel->find($id);
        if (!$service) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Service not found.');
        }

        $rules = [
            'name'           => 'required|min_length[3]|max_length[150]',
            'starting_price' => 'permit_empty|numeric',
            'image'          => 'permit_empty|is_image[image]|max_size[image,3072]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = trim($this->request->getPost('name'));
        $slug = url_title($name, '-', true);

        $existing = $this->serviceModel->where('slug', $slug)->where('id !=', $id)->first();
        if ($existing) {
            $slug .= '-' . time();
        }

        $imageName = $service['image'];
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName();
            $uploadPath = ROOTPATH . 'public/uploads/services';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $file->move($uploadPath, $imageName);
        }

        $this->serviceModel->update($id, [
            'name'              => $name,
            'slug'              => $slug,
            'icon'              => trim($this->request->getPost('icon') ?? 'bi bi-tools'),
            'image'             => $imageName,
            'short_description' => trim($this->request->getPost('short_description') ?? ''),
            'full_description'  => $this->request->getPost('full_description'),
            'features'          => trim($this->request->getPost('features') ?? ''),
            'turnaround_time'   => trim($this->request->getPost('turnaround_time') ?? ''),
            'starting_price'    => $this->request->getPost('starting_price') !== '' ? (float)$this->request->getPost('starting_price') : null,
            'is_featured'       => $this->request->getPost('is_featured') ? 1 : 0,
            'status'            => $this->request->getPost('status') ?? 'active',
        ]);

        return redirect()->to(base_url('admin/services'))->with('success', 'Service updated successfully!');
    }

    public function delete($id)
    {
        $service = $this->serviceModel->find($id);
        if ($service) {
            $this->serviceModel->delete($id);
            return redirect()->to(base_url('admin/services'))->with('success', 'Service deleted successfully.');
        }
        return redirect()->to(base_url('admin/services'))->with('error', 'Service not found.');
    }
}
