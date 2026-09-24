<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\ProductImageModel;
use App\Models\CategoryModel;
use App\Models\BrandModel;
use App\Models\WishlistItemModel;

class Product extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $brandModel;

    public function __construct()
    {
        $this->productModel  = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->brandModel    = new BrandModel();
    }

    public function index()
    {
        $categorySlug = $this->request->getGet('category');
        $brandSlug    = $this->request->getGet('brand');
        $search       = $this->request->getGet('q');
        $sort         = $this->request->getGet('sort') ?? 'latest';
        $stockStatus  = $this->request->getGet('stock');
        $page         = (int)($this->request->getGet('page') ?? 1);
        $perPage      = 12;
        $offset       = ($page - 1) * $perPage;

        $filters = [
            'category_slug' => $categorySlug,
            'brand_slug'    => $brandSlug,
            'search'        => $search,
            'sort'          => $sort,
            'stock_status'  => $stockStatus,
        ];

        $products   = $this->productModel->getFilteredProducts($filters, $perPage, $offset);
        $totalItems = $this->productModel->countFilteredProducts($filters);
        $totalPages = ceil($totalItems / $perPage);

        $categories = $this->categoryModel->getActiveCategories();
        $brands     = $this->brandModel->getActiveBrands();

        // User Wishlist
        $userWishlistIds = [];
        if (session()->get('isLoggedIn')) {
            $wishlistItemModel = new WishlistItemModel();
            $items = $wishlistItemModel->getUserWishlistItems(session()->get('user_id'));
            $userWishlistIds = array_column($items, 'product_id');
        }

        // Active Category / Brand Object for SEO / Breadcrumb
        $activeCategory = $categorySlug ? $this->categoryModel->where('slug', $categorySlug)->first() : null;
        $activeBrand    = $brandSlug ? $this->brandModel->where('slug', $brandSlug)->first() : null;

        $pageTitle = 'Explore Computer Products & Hardware';
        if ($activeCategory) {
            $pageTitle = esc($activeCategory['name']) . ' - Products';
        } elseif ($activeBrand) {
            $pageTitle = esc($activeBrand['name']) . ' - Products';
        } elseif ($search) {
            $pageTitle = 'Search Results for "' . esc($search) . '"';
        }

        $data = [
            'page_title'      => $pageTitle . ' | Balaji Computech',
            'products'        => $products,
            'totalItems'      => $totalItems,
            'currentPage'     => $page,
            'totalPages'      => $totalPages,
            'categories'      => $categories,
            'brands'          => $brands,
            'filters'         => $filters,
            'activeCategory'  => $activeCategory,
            'activeBrand'     => $activeBrand,
            'userWishlistIds' => $userWishlistIds,
        ];

        return view('products/index', $data);
    }

    public function detail($slug)
    {
        $product = $this->productModel->getProductBySlug($slug);
        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Product not found: ' . $slug);
        }

        // Increment view count
        $this->productModel->update($product['id'], ['views_count' => (int)$product['views_count'] + 1]);

        // Gallery images
        $imageModel = new ProductImageModel();
        $galleryImages = $imageModel->where('product_id', $product['id'])->orderBy('sort_order', 'ASC')->findAll();

        // Related products in same category
        $relatedProducts = $this->productModel->where('category_id', $product['category_id'])
                                              ->where('id !=', $product['id'])
                                              ->where('status', 'active')
                                              ->orderBy('id', 'DESC')
                                              ->limit(4)
                                              ->findAll();

        // Check if in wishlist
        $inWishlist = false;
        if (session()->get('isLoggedIn')) {
            $wishlistItemModel = new WishlistItemModel();
            $inWishlist = $wishlistItemModel->isProductInWishlist(session()->get('user_id'), $product['id']);
        }

        // WhatsApp inquiry message template
        $priceText = $product['discount_price'] ? '₹' . number_format($product['discount_price'], 2) : ($product['price'] ? '₹' . number_format($product['price'], 2) : 'Price on Inquiry');
        $waMessage = "Hello Gourav Joshi / Balaji Computech,\n\nI am interested in:\nProduct: {$product['name']}\nSKU: {$product['sku']}\nPrice: {$priceText}\nLink: " . current_url() . "\n\nPlease let me know availability and best pricing. Thank you!";
        $whatsappUrl = get_whatsapp_url($waMessage);

        $data = [
            'page_title'      => esc($product['name']) . ' | Balaji Computech Dewas',
            'product'         => $product,
            'galleryImages'   => $galleryImages,
            'relatedProducts' => $relatedProducts,
            'inWishlist'      => $inWishlist,
            'whatsappUrl'     => $whatsappUrl,
        ];

        return view('products/detail', $data);
    }
}
