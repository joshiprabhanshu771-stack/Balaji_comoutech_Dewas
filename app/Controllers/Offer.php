<?php

namespace App\Controllers;

use App\Models\OfferModel;

class Offer extends BaseController
{
    public function index()
    {
        $offerModel = new OfferModel();
        try {
            $offers = $offerModel->getActiveOffers();
        } catch (\Throwable $e) {
            log_message('error', 'Offer index load error: ' . $e->getMessage());
            $offers = [];
        }

        return view('offers/index', [
            'page_title' => 'Special Deals & Upgrade Offers | Balaji Computech Dewas',
            'offers'     => $offers,
        ]);
    }
}

