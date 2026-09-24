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
        $brands = $this->brandModel->getActiveBrands();

        return view('brands/index', [
            'page_title' => 'Authorized Brands & Partners | Balaji Computech',
            'brands'     => $brands,
        ]);
    }

    public function detail($slug)
    {
        $brand = $this->brandModel->where('slug', $slug)->where('status', 'active')->first();
        if (!$brand) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Brand not found: ' . $slug);
        }

        $products = $this->productModel->getFilteredProducts(['brand_slug' => $slug], 20);

        // User Wishlist
        $userWishlistIds = [];
        if (session()->get('isLoggedIn')) {
            $wishlistItemModel = new WishlistItemModel();
            $items = $wishlistItemModel->getUserWishlistItems(session()->get('user_id'));
            $userWishlistIds = array_column($items, 'product_id');
        }

        return view('brands/detail', [
            'page_title'      => esc($brand['name']) . ' Products & Hardware | Balaji Computech',
            'brand'           => $brand,
            'products'        => $products,
            'userWishlistIds' => $userWishlistIds,
        ]);
    }
}
