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

        $featuredCategories = $categoryModel->getActiveCategories(true);
        $allCategories      = $categoryModel->getActiveCategories(false);
        $featuredBrands      = $brandModel->getActiveBrands(true);
        $featuredProducts    = $productModel->getFilteredProducts(['is_featured' => 1], 8);
        $hotDeals           = $productModel->getFilteredProducts(['is_hot_deal' => 1], 6);
        $services           = $serviceModel->getActiveServices(true);
        $offers             = $offerModel->getActiveOffers();
        $faqs               = $faqModel->where('is_active', 1)->orderBy('sort_order', 'ASC')->limit(6)->findAll();
        $primaryLocation    = $presenceModel->getPrimaryLocation();

        // User wishlist product IDs if logged in
        $userWishlistIds = [];
        if (session()->get('isLoggedIn')) {
            $wishlistItemModel = new WishlistItemModel();
            $items = $wishlistItemModel->getUserWishlistItems(session()->get('user_id'));
            $userWishlistIds = array_column($items, 'product_id');
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
        $presenceModel = new PresenceModel();
        $locations = $presenceModel->orderBy('is_primary', 'DESC')->findAll();

        return view('our_presence', [
            'page_title' => 'Our Store Presence & Location | Balaji Computech Dewas',
            'locations'  => $locations,
        ]);
    }
}
