<?php

namespace App\Models;

use CodeIgniter\Model;

class WishlistItemModel extends Model
{
    protected $table            = 'wishlist_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'wishlist_id',
        'product_id',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getUserWishlistItems($userId)
    {
        return $this->select('wishlist_items.*, products.name, products.slug, products.price, products.discount_price, products.stock_status, products.main_image, categories.name as category_name, brands.name as brand_name')
                    ->join('wishlists', 'wishlists.id = wishlist_items.wishlist_id')
                    ->join('products', 'products.id = wishlist_items.product_id')
                    ->join('categories', 'categories.id = products.category_id', 'left')
                    ->join('brands', 'brands.id = products.brand_id', 'left')
                    ->where('wishlists.user_id', $userId)
                    ->where('products.status', 'active')
                    ->orderBy('wishlist_items.id', 'DESC')
                    ->findAll();
    }

    public function isProductInWishlist($userId, $productId)
    {
        return $this->join('wishlists', 'wishlists.id = wishlist_items.wishlist_id')
                    ->where('wishlists.user_id', $userId)
                    ->where('wishlist_items.product_id', $productId)
                    ->countAllResults() > 0;
    }
}
