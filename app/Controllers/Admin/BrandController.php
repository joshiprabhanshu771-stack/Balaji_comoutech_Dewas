<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BrandModel;

class BrandController extends BaseController
{
    protected $brandModel;

    public function __construct()
    {
        $this->brandModel = new BrandModel();
    }

    public function index()
    {
        $brands = $this->brandModel->orderBy('name', 'ASC')->findAll();

        return view('admin/brands/index', [
            'page_title' => 'Brand Management | Admin',
            'brands'     => $brands,
        ]);
    }

    public function create()
    {
        return view('admin/brands/create', [
            'page_title' => 'Add New Brand | Admin',
        ]);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'logo' => 'permit_empty|is_image[logo]|max_size[logo,2048]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = trim($this->request->getPost('name'));
        $slug = url_title($name, '-', true);

        $existing = $this->brandModel->where('slug', $slug)->first();
        if ($existing) {
            $slug .= '-' . time();
        }

        $logoName = null;
        $file = $this->request->getFile('logo');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $logoName = $file->getRandomName();
            $uploadPath = ROOTPATH . 'public/uploads/brands';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $file->move($uploadPath, $logoName);
        }

        $this->brandModel->insert([
            'name'        => $name,
            'slug'        => $slug,
            'description' => trim($this->request->getPost('description') ?? ''),
            'logo'        => $logoName,
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'status'      => $this->request->getPost('status') ?? 'active',
        ]);

        return redirect()->to(base_url('admin/brands'))->with('success', 'Brand created successfully!');
    }

    public function edit($id)
    {
        $brand = $this->brandModel->find($id);
        if (!$brand) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Brand not found.');
        }

        return view('admin/brands/edit', [
            'page_title' => 'Edit Brand: ' . esc($brand['name']),
            'brand'      => $brand,
        ]);
    }

    public function update($id)
    {
        $brand = $this->brandModel->find($id);
        if (!$brand) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Brand not found.');
        }

        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'logo' => 'permit_empty|is_image[logo]|max_size[logo,2048]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = trim($this->request->getPost('name'));
        $slug = url_title($name, '-', true);

        $existing = $this->brandModel->where('slug', $slug)->where('id !=', $id)->first();
        if ($existing) {
            $slug .= '-' . time();
        }

        $logoName = $brand['logo'];
        $file = $this->request->getFile('logo');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $logoName = $file->getRandomName();
            $uploadPath = ROOTPATH . 'public/uploads/brands';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $file->move($uploadPath, $logoName);
        }

        $this->brandModel->update($id, [
            'name'        => $name,
            'slug'        => $slug,
            'description' => trim($this->request->getPost('description') ?? ''),
            'logo'        => $logoName,
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'status'      => $this->request->getPost('status') ?? 'active',
        ]);

        return redirect()->to(base_url('admin/brands'))->with('success', 'Brand updated successfully!');
    }

    public function delete($id)
    {
        $brand = $this->brandModel->find($id);
        if ($brand) {
            $this->brandModel->delete($id);
            return redirect()->to(base_url('admin/brands'))->with('success', 'Brand deleted successfully.');
        }
        return redirect()->to(base_url('admin/brands'))->with('error', 'Brand not found.');
    }
}
