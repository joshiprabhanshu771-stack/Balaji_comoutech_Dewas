<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\BrandModel;
use App\Models\ProductImageModel;

class ProductController extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $brandModel;
    protected $imageModel;

    public function __construct()
    {
        $this->productModel  = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->brandModel    = new BrandModel();
        $this->imageModel    = new ProductImageModel();
    }

    public function index()
    {
        $search = $this->request->getGet('q');
        $catId  = $this->request->getGet('category_id');

        $builder = $this->productModel->select('products.*, categories.name as category_name, brands.name as brand_name')
                                      ->join('categories', 'categories.id = products.category_id', 'left')
                                      ->join('brands', 'brands.id = products.brand_id', 'left');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('products.name', $search)
                    ->orLike('products.sku', $search)
                    ->groupEnd();
        }
        if (!empty($catId)) {
            $builder->where('products.category_id', $catId);
        }

        $products = $builder->orderBy('products.id', 'DESC')->paginate(15);
        $pager    = $this->productModel->pager;

        return view('admin/products/index', [
            'page_title' => 'Product Management | Admin',
            'products'   => $products,
            'pager'      => $pager,
            'categories' => $this->categoryModel->findAll(),
            'search'     => $search,
            'catId'      => $catId,
        ]);
    }

    public function create()
    {
        return view('admin/products/create', [
            'page_title' => 'Add New Product | Admin',
            'categories' => $this->categoryModel->where('status', 'active')->findAll(),
            'brands'     => $this->brandModel->where('status', 'active')->findAll(),
        ]);
    }

    public function store()
    {
        $rules = [
            'name'           => 'required|min_length[3]|max_length[200]',
            'category_id'    => 'required|is_natural_no_zero',
            'price'          => 'permit_empty|numeric',
            'discount_price' => 'permit_empty|numeric',
            'main_image'     => 'permit_empty|is_image[main_image]|max_size[main_image,4096]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = trim($this->request->getPost('name'));
        $slug = url_title($name, '-', true);

        // Ensure unique slug
        $count = $this->productModel->where('slug', $slug)->countAllResults();
        if ($count > 0) {
            $slug .= '-' . time();
        }

        $imageName = null;
        $file = $this->request->getFile('main_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName();
            $uploadPath = ROOTPATH . 'public/uploads/products';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $file->move($uploadPath, $imageName);
        }

        $data = [
            'category_id'       => (int)$this->request->getPost('category_id'),
            'brand_id'          => $this->request->getPost('brand_id') ? (int)$this->request->getPost('brand_id') : null,
            'name'              => $name,
            'slug'              => $slug,
            'sku'               => trim($this->request->getPost('sku') ?? ''),
            'short_description' => trim($this->request->getPost('short_description') ?? ''),
            'full_description'  => $this->request->getPost('full_description'),
            'specifications'    => trim($this->request->getPost('specifications') ?? ''),
            'price'             => $this->request->getPost('price') !== '' ? (float)$this->request->getPost('price') : null,
            'discount_price'    => $this->request->getPost('discount_price') !== '' ? (float)$this->request->getPost('discount_price') : null,
            'stock_status'      => $this->request->getPost('stock_status') ?? 'in_stock',
            'main_image'        => $imageName,
            'is_featured'       => $this->request->getPost('is_featured') ? 1 : 0,
            'is_hot_deal'       => $this->request->getPost('is_hot_deal') ? 1 : 0,
            'status'            => $this->request->getPost('status') ?? 'active',
        ];

        $productId = $this->productModel->insert($data);

        return redirect()->to(base_url('admin/products'))->with('success', 'Product added successfully!');
    }

    public function edit($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Product not found.');
        }

        return view('admin/products/edit', [
            'page_title' => 'Edit Product: ' . esc($product['name']),
            'product'    => $product,
            'categories' => $this->categoryModel->findAll(),
            'brands'     => $this->brandModel->findAll(),
        ]);
    }

    public function update($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Product not found.');
        }

        $rules = [
            'name'           => 'required|min_length[3]|max_length[200]',
            'category_id'    => 'required|is_natural_no_zero',
            'price'          => 'permit_empty|numeric',
            'discount_price' => 'permit_empty|numeric',
            'main_image'     => 'permit_empty|is_image[main_image]|max_size[main_image,4096]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = trim($this->request->getPost('name'));
        $slug = url_title($name, '-', true);

        // Check unique slug excluding current
        $existing = $this->productModel->where('slug', $slug)->where('id !=', $id)->first();
        if ($existing) {
            $slug .= '-' . time();
        }

        $imageName = $product['main_image'];
        $file = $this->request->getFile('main_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $imageName = $file->getRandomName();
            $uploadPath = ROOTPATH . 'public/uploads/products';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $file->move($uploadPath, $imageName);
        }

        $data = [
            'category_id'       => (int)$this->request->getPost('category_id'),
            'brand_id'          => $this->request->getPost('brand_id') ? (int)$this->request->getPost('brand_id') : null,
            'name'              => $name,
            'slug'              => $slug,
            'sku'               => trim($this->request->getPost('sku') ?? ''),
            'short_description' => trim($this->request->getPost('short_description') ?? ''),
            'full_description'  => $this->request->getPost('full_description'),
            'specifications'    => trim($this->request->getPost('specifications') ?? ''),
            'price'             => $this->request->getPost('price') !== '' ? (float)$this->request->getPost('price') : null,
            'discount_price'    => $this->request->getPost('discount_price') !== '' ? (float)$this->request->getPost('discount_price') : null,
            'stock_status'      => $this->request->getPost('stock_status') ?? 'in_stock',
            'main_image'        => $imageName,
            'is_featured'       => $this->request->getPost('is_featured') ? 1 : 0,
            'is_hot_deal'       => $this->request->getPost('is_hot_deal') ? 1 : 0,
            'status'            => $this->request->getPost('status') ?? 'active',
        ];

        $this->productModel->update($id, $data);

        return redirect()->to(base_url('admin/products'))->with('success', 'Product updated successfully!');
    }

    public function delete($id)
    {
        $product = $this->productModel->find($id);
        if ($product) {
            $this->productModel->delete($id);
            return redirect()->to(base_url('admin/products'))->with('success', 'Product deleted successfully.');
        }
        return redirect()->to(base_url('admin/products'))->with('error', 'Product not found.');
    }
}
