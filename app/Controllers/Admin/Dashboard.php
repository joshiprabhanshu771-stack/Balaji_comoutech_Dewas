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
        $stats = [
            'total_products'    => 0,
            'total_categories'  => 0,
            'total_inquiries'   => 0,
            'pending_inquiries' => 0,
            'total_services'    => 0,
            'active_offers'     => 0,
            'total_customers'   => 0,
            'unread_messages'   => 0,
        ];
        $recentInquiries = [];
        $recentMessages  = [];

        try {
            $productModel  = new ProductModel();
            $categoryModel = new CategoryModel();
            $inquiryModel  = new InquiryModel();
            $serviceModel  = new ServiceModel();
            $offerModel    = new OfferModel();
            $userModel     = new UserModel();
            $contactModel  = new ContactMessageModel();

            $stats['total_products']    = (int)$productModel->countAllResults();
            $stats['total_categories']  = (int)$categoryModel->countAllResults();
            $stats['total_inquiries']   = (int)$inquiryModel->countAllResults();
            $stats['pending_inquiries'] = (int)$inquiryModel->where('status', 'pending')->countAllResults();
            $stats['total_services']    = (int)$serviceModel->countAllResults();
            $stats['active_offers']     = (int)$offerModel->where('is_active', 1)->countAllResults();
            $stats['total_customers']   = (int)$userModel->where('role_id', 2)->countAllResults();
            $stats['unread_messages']   = (int)$contactModel->where('is_read', 0)->countAllResults();

            $recentInquiries = $inquiryModel->getInquiriesWithDetails([], 8);
            $recentMessages  = $contactModel->orderBy('id', 'DESC')->limit(5)->findAll();
        } catch (\Throwable $e) {
            log_message('error', 'Admin Dashboard stats load error: ' . $e->getMessage());
        }

        return view('admin/dashboard', [
            'page_title'      => 'Shopkeeper Admin Dashboard | Balaji Computech',
            'stats'           => $stats,
            'recentInquiries' => $recentInquiries,
            'recentMessages'  => $recentMessages,
        ]);
    }
}
