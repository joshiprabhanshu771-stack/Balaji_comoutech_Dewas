<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PageModel;

class PageController extends BaseController
{
    protected $pageModel;

    public function __construct()
    {
        $this->pageModel = new PageModel();
    }

    public function index()
    {
        $pages = $this->pageModel->findAll();

        return view('admin/pages/index', [
            'page_title' => 'Content Pages Management | Admin',
            'pages'      => $pages,
        ]);
    }

    public function create()
    {
        return view('admin/pages/create', [
            'page_title' => 'Add New Page | Admin',
        ]);
    }

    public function store()
    {
        $rules = [
            'title'   => 'required|min_length[3]|max_length[150]',
            'content' => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $title = trim($this->request->getPost('title'));
        $slug = url_title($title, '-', true);

        $existing = $this->pageModel->where('slug', $slug)->first();
        if ($existing) {
            $slug .= '-' . time();
        }

        $this->pageModel->insert([
            'title'            => $title,
            'slug'             => $slug,
            'content'          => $this->request->getPost('content'),
            'meta_title'       => trim($this->request->getPost('meta_title') ?? ''),
            'meta_description' => trim($this->request->getPost('meta_description') ?? ''),
            'is_active'        => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to(base_url('admin/pages'))->with('success', 'Page created successfully!');
    }

    public function edit($id)
    {
        $page = $this->pageModel->find($id);
        if (!$page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Page not found.');
        }

        return view('admin/pages/edit', [
            'page_title' => 'Edit Page: ' . esc($page['title']),
            'page'       => $page,
        ]);
    }

    public function update($id)
    {
        $page = $this->pageModel->find($id);
        if (!$page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Page not found.');
        }

        $rules = [
            'title'   => 'required|min_length[3]|max_length[150]',
            'content' => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $title = trim($this->request->getPost('title'));
        $slug = url_title($title, '-', true);

        $existing = $this->pageModel->where('slug', $slug)->where('id !=', $id)->first();
        if ($existing) {
            $slug .= '-' . time();
        }

        $this->pageModel->update($id, [
            'title'            => $title,
            'slug'             => $slug,
            'content'          => $this->request->getPost('content'),
            'meta_title'       => trim($this->request->getPost('meta_title') ?? ''),
            'meta_description' => trim($this->request->getPost('meta_description') ?? ''),
            'is_active'        => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to(base_url('admin/pages'))->with('success', 'Page updated successfully!');
    }

    public function delete($id)
    {
        $page = $this->pageModel->find($id);
        if ($page) {
            $this->pageModel->delete($id);
            return redirect()->to(base_url('admin/pages'))->with('success', 'Page deleted successfully.');
        }
        return redirect()->to(base_url('admin/pages'))->with('error', 'Page not found.');
    }
}
