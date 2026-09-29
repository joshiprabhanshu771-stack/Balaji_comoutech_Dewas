<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\BrandModel;
use App\Models\ProductModel;
use App\Models\ServiceModel;
use App\Models\OfferModel;
use App\Models\FaqModel;
use App\Models\PresenceModel;
use App\Models\WishlistItemModel;

class Home extends BaseController
{
    public function index()
    {
        $categoryModel = new CategoryModel();
        $brandModel    = new BrandModel();
        $productModel  = new ProductModel();
        $serviceModel  = new ServiceModel();
        $offerModel    = new OfferModel();
        $faqModel      = new FaqModel();
        $presenceModel = new PresenceModel();

        try {
            $featuredCategories = $categoryModel->getActiveCategories(true);
            $allCategories      = $categoryModel->getActiveCategories(false);
            $featuredBrands     = $brandModel->getActiveBrands(true);
            $featuredProducts   = $productModel->getFilteredProducts(['is_featured' => 1], 8);
            $hotDeals           = $productModel->getFilteredProducts(['is_hot_deal' => 1], 6);
            $services           = $serviceModel->getActiveServices(true);
            $offers             = $offerModel->getActiveOffers();
            $faqs               = $faqModel->where('is_active', 1)->orderBy('sort_order', 'ASC')->limit(6)->findAll();
            $primaryLocation    = $presenceModel->getPrimaryLocation();
        } catch (\Throwable $e) {
            log_message('error', 'Home::index data retrieval error: ' . $e->getMessage());
            $featuredCategories = [];
            $allCategories      = [];
            $featuredBrands     = [];
            $featuredProducts   = [];
            $hotDeals           = [];
            $services           = [];
            $offers             = [];
            $faqs               = [];
            $primaryLocation    = null;
        }

        // User wishlist product IDs if logged in
        $userWishlistIds = [];
        if (session()->get('isLoggedIn')) {
            try {
                $wishlistItemModel = new WishlistItemModel();
                $items = $wishlistItemModel->getUserWishlistItems(session()->get('user_id'));
                $userWishlistIds = array_column($items, 'product_id');
            } catch (\Throwable $e) {
                log_message('error', 'Home::index wishlist error: ' . $e->getMessage());
                $userWishlistIds = [];
            }
        }

        $data = [
            'page_title'         => 'Balaji Computech - Best Computer Shop & Laptop Repair Center in Dewas',
            'featuredCategories' => $featuredCategories,
            'allCategories'      => $allCategories,
            'featuredBrands'     => $featuredBrands,
            'featuredProducts'   => $featuredProducts,
            'hotDeals'           => $hotDeals,
            'services'           => $services,
            'offers'             => $offers,
            'faqs'               => $faqs,
            'primaryLocation'    => $primaryLocation,
            'userWishlistIds'    => $userWishlistIds,
        ];

        return view('home', $data);
    }

    public function presence()
    {
        try {
            $presenceModel = new PresenceModel();
            $locations = $presenceModel->orderBy('is_primary', 'DESC')->findAll();
            if (empty($locations)) {
                $primary = $presenceModel->getPrimaryLocation();
                if ($primary) {
                    $locations = [$primary];
                }
            }
        } catch (\Throwable $e) {
            log_message('error', 'Home::presence error: ' . $e->getMessage());
            $locations = [];
        }

        if (empty($locations)) {
            $locations = [
                [
                    'id'                => 1,
                    'title'             => 'Balaji Computech - Main Showroom & Repair Lab',
                    'address'           => 'Shop No. 12, Mainashree Complex, Near Netram, AB Road, Dewas, Madhya Pradesh - 455001',
                    'address_line1'     => 'Shop No. 12, Mainashree Complex',
                    'address_line2'     => 'Near Netram, AB Road',
                    'city'              => 'Dewas',
                    'state'             => 'Madhya Pradesh',
                    'pincode'           => '455001',
                    'phone'             => get_setting('contact_phone', '+91 98260 12345'),
                    'alternate_phone'   => '+91 72720 00000',
                    'email'             => get_setting('contact_email', 'info@balajicomputech.com'),
                    'landmark'          => 'Near Netram Hotel, Main AB Road',
                    'opening_hours'     => get_setting('opening_hours', 'Mon - Sat: 10:00 AM - 08:30 PM | Sun: 11:00 AM - 04:00 PM'),
                    'google_maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d117565.41926694665!2d76.00287612739345!3d22.959955745164283!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39631742468bb03b%3A0x6b8b0e797e55fae2!2sDewas%2C%20Madhya%20Pradesh!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin" width="100%" height="380" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                    'is_primary'        => 1,
                ]
            ];
        }

        return view('our_presence', [
            'page_title' => 'Our Store Presence & Location | Balaji Computech Dewas',
            'locations'  => $locations,
        ]);
    }
}

