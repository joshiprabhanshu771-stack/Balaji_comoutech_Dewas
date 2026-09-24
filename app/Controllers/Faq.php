<?php

namespace App\Controllers;

use App\Models\FaqModel;

class Faq extends BaseController
{
    public function index()
    {
        $faqModel = new FaqModel();
        $faqGroups = $faqModel->getActiveFaqsGrouped();

        return view('faq/index', [
            'page_title' => 'Frequently Asked Questions (FAQ) | Balaji Computech',
            'faqGroups'  => $faqGroups,
        ]);
    }
}
