<?php

namespace App\Controllers;

use App\Models\FaqModel;

class Faq extends BaseController
{
    public function index()
    {
        $faqModel = new FaqModel();
        try {
            $faqGroups = $faqModel->getActiveFaqsGrouped();
        } catch (\Throwable $e) {
            log_message('error', 'Faq index load error: ' . $e->getMessage());
            $faqGroups = [];
        }

        return view('faq/index', [
            'page_title' => 'Frequently Asked Questions (FAQ) | Balaji Computech',
            'faqGroups'  => $faqGroups,
        ]);
    }
}

