<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OfferModel;

class OfferController extends BaseController
{
    protected $offerModel;

    public function __construct()
    {
        $this->offerModel = new OfferModel();
    }

    public function index()
    {
        $offers = $this->offerModel->orderBy('id', 'DESC')->findAll();

        return view('admin/offers/index', [
            'page_title' => 'Promotional Offers & Deals | Admin',
            'offers'     => $offers,
        ]);
    }

    public function create()
    {
        return view('admin/offers/create', [
            'page_title' => 'Add New Offer | Admin',
        ]);
    }

    public function store()
    {
        $rules = [
            'title'        => 'required|min_length[3]|max_length[200]',
            'banner_image' => 'permit_empty|is_image[banner_image]|max_size[banner_image,3072]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $title = trim($this->request->getPost('title'));
        $slug = url_title($title, '-', true);

        $existing = $this->offerModel->where('slug', $slug)->first();
        if ($existing) {
            $slug .= '-' . time();
        }

        $imageName = null;
        $file = $this->request->getFile('banner_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName();
            $uploadPath = ROOTPATH . 'public/uploads/offers';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $file->move($uploadPath, $imageName);
        }

        $startDate = $this->request->getPost('start_date') ?: ($this->request->getPost('valid_from') ?: null);
        $endDate   = $this->request->getPost('end_date') ?: ($this->request->getPost('valid_until') ?: null);
        $isActive  = $this->request->getPost('is_active') ? 1 : 0;

        $this->offerModel->insert([
            'title'         => $title,
            'slug'          => $slug,
            'description'   => trim($this->request->getPost('description') ?? ''),
            'banner_image'  => $imageName,
            'discount_text' => trim($this->request->getPost('discount_text') ?? ''),
            'coupon_code'   => trim($this->request->getPost('coupon_code') ?? ''),
            'start_date'    => $startDate,
            'end_date'      => $endDate,
            'valid_from'    => $startDate,
            'valid_until'   => $endDate,
            'is_active'     => $isActive,
            'status'        => $isActive ? 'active' : 'inactive',
        ]);

        return redirect()->to(base_url('admin/offers'))->with('success', 'Offer created successfully!');
    }

    public function edit($id)
    {
        $offer = $this->offerModel->find($id);
        if (!$offer) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Offer not found.');
        }

        return view('admin/offers/edit', [
            'page_title' => 'Edit Offer: ' . esc($offer['title']),
            'offer'      => $offer,
        ]);
    }

    public function update($id)
    {
        $offer = $this->offerModel->find($id);
        if (!$offer) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Offer not found.');
        }

        $rules = [
            'title'        => 'required|min_length[3]|max_length[200]',
            'banner_image' => 'permit_empty|is_image[banner_image]|max_size[banner_image,3072]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $title = trim($this->request->getPost('title'));
        $slug = url_title($title, '-', true);

        $existing = $this->offerModel->where('slug', $slug)->where('id !=', $id)->first();
        if ($existing) {
            $slug .= '-' . time();
        }

        $imageName = $offer['banner_image'];
        $file = $this->request->getFile('banner_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName();
            $uploadPath = ROOTPATH . 'public/uploads/offers';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $file->move($uploadPath, $imageName);
        }

        $startDate = $this->request->getPost('start_date') ?: ($this->request->getPost('valid_from') ?: null);
        $endDate   = $this->request->getPost('end_date') ?: ($this->request->getPost('valid_until') ?: null);
        $isActive  = $this->request->getPost('is_active') ? 1 : 0;

        $this->offerModel->update($id, [
            'title'         => $title,
            'slug'          => $slug,
            'description'   => trim($this->request->getPost('description') ?? ''),
            'banner_image'  => $imageName,
            'discount_text' => trim($this->request->getPost('discount_text') ?? ''),
            'coupon_code'   => trim($this->request->getPost('coupon_code') ?? ''),
            'start_date'    => $startDate,
            'end_date'      => $endDate,
            'valid_from'    => $startDate,
            'valid_until'   => $endDate,
            'is_active'     => $isActive,
            'status'        => $isActive ? 'active' : 'inactive',
        ]);

        return redirect()->to(base_url('admin/offers'))->with('success', 'Offer updated successfully!');
    }

    public function delete($id)
    {
        $offer = $this->offerModel->find($id);
        if ($offer) {
            $this->offerModel->delete($id);
            return redirect()->to(base_url('admin/offers'))->with('success', 'Offer deleted successfully.');
        }
        return redirect()->to(base_url('admin/offers'))->with('error', 'Offer not found.');
    }
}
