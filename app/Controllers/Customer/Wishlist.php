<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\WishlistItemModel;

class Wishlist extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        $wishlistItemModel = new WishlistItemModel();

        $items = $wishlistItemModel->getUserWishlistItems($userId);

        return view('customer/wishlist', [
            'page_title' => 'My Wishlist & Saved Products | Balaji Computech',
            'items'      => $items,
        ]);
    }
}
