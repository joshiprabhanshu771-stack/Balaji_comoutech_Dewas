<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $categories = $this->categoryModel->orderBy('sort_order', 'ASC')->findAll();

        return view('admin/categories/index', [
            'page_title' => 'Category Management | Admin',
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return view('admin/categories/create', [
            'page_title' => 'Add New Category | Admin',
        ]);
    }

    public function store()
    {
        $rules = [
            'name'  => 'required|min_length[2]|max_length[100]',
            'image' => 'permit_empty|is_image[image]|max_size[image,3072]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = trim($this->request->getPost('name'));
        $slug = url_title($name, '-', true);

        $existing = $this->categoryModel->where('slug', $slug)->first();
        if ($existing) {
            $slug .= '-' . time();
        }

        $imageName = null;
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName();
            $uploadPath = ROOTPATH . 'public/uploads/categories';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $file->move($uploadPath, $imageName);
        }

        $this->categoryModel->insert([
            'name'        => $name,
            'slug'        => $slug,
            'description' => trim($this->request->getPost('description') ?? ''),
            'image'       => $imageName,
            'icon'        => trim($this->request->getPost('icon') ?? 'bi bi-folder'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'status'      => $this->request->getPost('status') ?? 'active',
            'sort_order'  => (int)$this->request->getPost('sort_order'),
        ]);

        return redirect()->to(base_url('admin/categories'))->with('success', 'Category created successfully!');
    }

    public function edit($id)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Category not found.');
        }

        return view('admin/categories/edit', [
            'page_title' => 'Edit Category: ' . esc($category['name']),
            'category'   => $category,
        ]);
    }

    public function update($id)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Category not found.');
        }

        $rules = [
            'name'  => 'required|min_length[2]|max_length[100]',
            'image' => 'permit_empty|is_image[image]|max_size[image,3072]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = trim($this->request->getPost('name'));
        $slug = url_title($name, '-', true);

        $existing = $this->categoryModel->where('slug', $slug)->where('id !=', $id)->first();
        if ($existing) {
            $slug .= '-' . time();
        }

        $imageName = $category['image'];
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName();
            $uploadPath = ROOTPATH . 'public/uploads/categories';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $file->move($uploadPath, $imageName);
        }

        $this->categoryModel->update($id, [
            'name'        => $name,
            'slug'        => $slug,
            'description' => trim($this->request->getPost('description') ?? ''),
            'image'       => $imageName,
            'icon'        => trim($this->request->getPost('icon') ?? 'bi bi-folder'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'status'      => $this->request->getPost('status') ?? 'active',
            'sort_order'  => (int)$this->request->getPost('sort_order'),
        ]);

        return redirect()->to(base_url('admin/categories'))->with('success', 'Category updated successfully!');
    }

    public function delete($id)
    {
        $category = $this->categoryModel->find($id);
        if ($category) {
            $this->categoryModel->delete($id);
            return redirect()->to(base_url('admin/categories'))->with('success', 'Category deleted successfully.');
        }
        return redirect()->to(base_url('admin/categories'))->with('error', 'Category not found.');
    }
}
