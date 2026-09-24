<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\InquiryModel;
use App\Models\WishlistItemModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');

        $inquiryModel      = new InquiryModel();
        $wishlistItemModel = new WishlistItemModel();

        $totalInquiries   = $inquiryModel->where('user_id', $userId)->countAllResults();
        $pendingInquiries = $inquiryModel->where('user_id', $userId)->where('status', 'pending')->countAllResults();
        $repliedInquiries = $inquiryModel->where('user_id', $userId)->where('status', 'replied')->countAllResults();
        $wishlistItems    = $wishlistItemModel->getUserWishlistItems($userId);
        $totalWishlist    = count($wishlistItems);

        $recentInquiries = $inquiryModel->getInquiriesWithDetails(['user_id' => $userId], 5);

        return view('customer/dashboard', [
            'page_title'       => 'My Account Dashboard | Balaji Computech',
            'totalInquiries'   => $totalInquiries,
            'pendingInquiries' => $pendingInquiries,
            'repliedInquiries' => $repliedInquiries,
            'totalWishlist'    => $totalWishlist,
            'wishlistItems'    => array_slice($wishlistItems, 0, 4),
            'recentInquiries'  => $recentInquiries,
        ]);
    }
}
