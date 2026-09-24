<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FaqModel;

class FaqController extends BaseController
{
    protected $faqModel;

    public function __construct()
    {
        $this->faqModel = new FaqModel();
    }

    public function index()
    {
        $faqs = $this->faqModel->orderBy('category', 'ASC')->orderBy('sort_order', 'ASC')->findAll();

        return view('admin/faqs/index', [
            'page_title' => 'FAQ Management | Admin',
            'faqs'       => $faqs,
        ]);
    }

    public function create()
    {
        return view('admin/faqs/create', [
            'page_title' => 'Add New FAQ | Admin',
        ]);
    }

    public function store()
    {
        $rules = [
            'question' => 'required|min_length[5]',
            'answer'   => 'required|min_length[5]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->faqModel->insert([
            'category'   => trim($this->request->getPost('category') ?? 'General'),
            'question'   => trim($this->request->getPost('question')),
            'answer'     => trim($this->request->getPost('answer')),
            'sort_order' => (int)$this->request->getPost('sort_order'),
            'is_active'  => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to(base_url('admin/faqs'))->with('success', 'FAQ added successfully!');
    }

    public function edit($id)
    {
        $faq = $this->faqModel->find($id);
        if (!$faq) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('FAQ not found.');
        }

        return view('admin/faqs/edit', [
            'page_title' => 'Edit FAQ | Admin',
            'faq'        => $faq,
        ]);
    }

    public function update($id)
    {
        $faq = $this->faqModel->find($id);
        if (!$faq) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('FAQ not found.');
        }

        $rules = [
            'question' => 'required|min_length[5]',
            'answer'   => 'required|min_length[5]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->faqModel->update($id, [
            'category'   => trim($this->request->getPost('category') ?? 'General'),
            'question'   => trim($this->request->getPost('question')),
            'answer'     => trim($this->request->getPost('answer')),
            'sort_order' => (int)$this->request->getPost('sort_order'),
            'is_active'  => $this->request->getPost('is_active') ? 1 : 0,
        ]);

        return redirect()->to(base_url('admin/faqs'))->with('success', 'FAQ updated successfully!');
    }

    public function delete($id)
    {
        $faq = $this->faqModel->find($id);
        if ($faq) {
            $this->faqModel->delete($id);
            return redirect()->to(base_url('admin/faqs'))->with('success', 'FAQ deleted successfully.');
        }
        return redirect()->to(base_url('admin/faqs'))->with('error', 'FAQ not found.');
    }
}
