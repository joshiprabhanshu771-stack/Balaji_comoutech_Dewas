<?php

namespace App\Controllers;

use App\Models\OfferModel;

class Offer extends BaseController
{
    public function index()
    {
        $offerModel = new OfferModel();
        $offers = $offerModel->getActiveOffers();

        return view('offers/index', [
            'page_title' => 'Special Deals & Upgrade Offers | Balaji Computech Dewas',
            'offers'     => $offers,
        ]);
    }
}
