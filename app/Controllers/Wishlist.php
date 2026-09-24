<?php

namespace App\Controllers;

use App\Models\WishlistModel;
use App\Models\WishlistItemModel;

class Wishlist extends BaseController
{
    public function toggle()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'status'  => 'auth_required',
                'message' => 'Please log in to save items to your wishlist.',
            ]);
        }

        $userId    = session()->get('user_id');
        $productId = (int)$this->request->getPost('product_id');

        if (!$productId) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid product ID.']);
        }

        $wishlistModel     = new WishlistModel();
        $wishlistItemModel = new WishlistItemModel();

        $wishlist = $wishlistModel->getOrCreateWishlist($userId);

        $existing = $wishlistItemModel->where('wishlist_id', $wishlist['id'])
                                      ->where('product_id', $productId)
                                      ->first();

        if ($existing) {
            $wishlistItemModel->delete($existing['id']);
            $action = 'removed';
            $message = 'Product removed from your wishlist.';
        } else {
            $wishlistItemModel->insert([
                'wishlist_id' => $wishlist['id'],
                'product_id'  => $productId,
            ]);
            $action = 'added';
            $message = 'Product added to your wishlist!';
        }

        // Count items
        $totalWishlist = $wishlistItemModel->where('wishlist_id', $wishlist['id'])->countAllResults();

        return $this->response->setJSON([
            'status'     => 'success',
            'action'     => $action,
            'message'    => $message,
            'count'      => $totalWishlist,
            'product_id' => $productId,
        ]);
    }

    public function remove($itemId)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('auth/login'));
        }

        $userId = session()->get('user_id');
        $wishlistItemModel = new WishlistItemModel();

        $item = $wishlistItemModel->select('wishlist_items.*, wishlists.user_id')
                                  ->join('wishlists', 'wishlists.id = wishlist_items.wishlist_id')
                                  ->where('wishlist_items.id', $itemId)
                                  ->where('wishlists.user_id', $userId)
                                  ->first();

        if ($item) {
            $wishlistItemModel->delete($itemId);
            return redirect()->back()->with('success', 'Item removed from your wishlist.');
        }

        return redirect()->back()->with('error', 'Item not found in your wishlist.');
    }
}
