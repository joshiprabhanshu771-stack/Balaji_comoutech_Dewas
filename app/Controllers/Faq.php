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

        if (empty($faqGroups)) {
            $faqGroups = [
                'General & Shop' => [
                    [
                        'id'       => 1,
                        'question' => 'Where is Balaji Computech located and what are the opening hours?',
                        'answer'   => 'We are located at Shop No. 12, Mainashree Complex, Near Netram, AB Road, Dewas, Madhya Pradesh (455001). We are open Monday to Saturday from 10:00 AM to 08:30 PM, and Sundays from 11:00 AM to 04:00 PM.',
                    ],
                    [
                        'id'       => 2,
                        'question' => 'Can I buy products directly through this website?',
                        'answer'   => 'This website is an online product showcase and inquiry catalog. We do not process online credit card/cart transactions. You can browse our full catalog, add items to your wishlist, send an inquiry through our site or click the WhatsApp button to chat directly with Gourav Joshi for instant pricing, availability, and shop pickup/delivery.',
                    ],
                ],
                'Products & Stock' => [
                    [
                        'id'       => 3,
                        'question' => 'Are all products 100% genuine with manufacturer warranty?',
                        'answer'   => 'Yes, absolutely! Every laptop, PC component, printer, monitor, and CCTV camera sold by Balaji Computech is 100% brand new, authentic, and backed by official brand warranty across India.',
                    ],
                    [
                        'id'       => 4,
                        'question' => 'Can you arrange a specific laptop model or computer part if not listed on the website?',
                        'answer'   => 'Yes! We have direct distributor tie-ups with HP, Dell, Lenovo, Asus, Intel, AMD, Gigabyte, MSI, and more. Send us the specific model number or configuration, and we can arrange it within 24-48 hours at competitive pricing.',
                    ],
                ],
                'Services & Repairs' => [
                    [
                        'id'       => 5,
                        'question' => 'How much time does it take for chip-level laptop repair?',
                        'answer'   => 'Most standard diagnostic and motherboard repairs take between 24 to 48 hours. Screen and keyboard replacements or SSD upgrades are usually done within 30 to 60 minutes.',
                    ],
                    [
                        'id'       => 6,
                        'question' => 'Do you provide onsite CCTV installation and home repair visits in Dewas?',
                        'answer'   => 'Yes, our certified technicians provide onsite site surveys, CCTV camera installations, network cabling, and home/office PC troubleshooting across Dewas and nearby surrounding areas.',
                    ],
                ]
            ];
        }

        return view('faq/index', [
            'page_title' => 'Frequently Asked Questions (FAQ) | Balaji Computech',
            'faqGroups'  => $faqGroups,
        ]);
    }
}


