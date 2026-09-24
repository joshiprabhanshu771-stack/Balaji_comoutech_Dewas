<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\InquiryModel;
use App\Models\ServiceModel;
use App\Models\OfferModel;
use App\Models\UserModel;
use App\Models\ContactMessageModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $productModel  = new ProductModel();
        $categoryModel = new CategoryModel();
        $inquiryModel  = new InquiryModel();
        $serviceModel  = new ServiceModel();
        $offerModel    = new OfferModel();
        $userModel     = new UserModel();
        $contactModel  = new ContactMessageModel();

        $stats = [
            'total_products'   => $productModel->countAllResults(),
            'total_categories' => $categoryModel->countAllResults(),
            'total_inquiries'  => $inquiryModel->countAllResults(),
            'pending_inquiries'=> $inquiryModel->where('status', 'pending')->countAllResults(),
            'total_services'   => $serviceModel->countAllResults(),
            'active_offers'    => $offerModel->where('is_active', 1)->countAllResults(),
            'total_customers'  => $userModel->where('role_id', 2)->countAllResults(),
            'unread_messages'  => $contactModel->where('is_read', 0)->countAllResults(),
        ];

        $recentInquiries = $inquiryModel->getInquiriesWithDetails([], 8);
        $recentMessages  = $contactModel->orderBy('id', 'DESC')->limit(5)->findAll();

        return view('admin/dashboard', [
            'page_title'      => 'Shopkeeper Admin Dashboard | Balaji Computech',
            'stats'           => $stats,
            'recentInquiries' => $recentInquiries,
            'recentMessages'  => $recentMessages,
        ]);
    }
}
