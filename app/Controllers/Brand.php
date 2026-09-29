<?php

namespace App\Controllers;

use App\Models\BrandModel;
use App\Models\ProductModel;
use App\Models\WishlistItemModel;

class Brand extends BaseController
{
    protected $brandModel;
    protected $productModel;

    public function __construct()
    {
        $this->brandModel   = new BrandModel();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        try {
            $brands = $this->brandModel->getActiveBrands();
        } catch (\Throwable $e) {
            log_message('error', 'Brand::index error: ' . $e->getMessage());
            $brands = [];
        }

        return view('brands/index', [
            'page_title' => 'Authorized Brands & Partners | Balaji Computech',
            'brands'     => $brands,
        ]);
    }

    public function detail($slug)
    {
        try {
            $brand = $this->brandModel->where('slug', $slug)->where('is_active', 1)->first();
        } catch (\Throwable $e) {
            log_message('error', 'Brand::detail error: ' . $e->getMessage());
            $brand = null;
        }

        if (!$brand) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Brand not found: ' . $slug);
        }

        try {
            $products = $this->productModel->getFilteredProducts(['brand_slug' => $slug], 20);
        } catch (\Throwable $e) {
            log_message('error', 'Brand::detail products error: ' . $e->getMessage());
            $products = [];
        }

        // User Wishlist
        $userWishlistIds = [];
        if (session()->get('isLoggedIn')) {
            try {
                $wishlistItemModel = new WishlistItemModel();
                $items = $wishlistItemModel->getUserWishlistItems(session()->get('user_id'));
                $userWishlistIds = array_column($items, 'product_id');
            } catch (\Throwable $e) {
                $userWishlistIds = [];
            }
        }

        return view('brands/detail', [
            'page_title'      => esc($brand['name']) . ' Products & Hardware | Balaji Computech',
            'brand'           => $brand,
            'products'        => $products,
            'userWishlistIds' => $userWishlistIds,
        ]);
    }

}
