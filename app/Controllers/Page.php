<?php

namespace App\Controllers;

use App\Models\PageModel;

class Page extends BaseController
{
    public function view($slug)
    {
        try {
            $pageModel = new PageModel();
            $page = $pageModel->getPageBySlug($slug);
        } catch (\Throwable $e) {
            log_message('error', 'Page::view error: ' . $e->getMessage());
            $page = null;
        }

        if (!$page) {
            $fallbacks = $this->getFallbackPages();
            if (isset($fallbacks[$slug])) {
                $page = $fallbacks[$slug];
            }
        }

        if (!$page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Page not found: ' . $slug);
        }

        return view('pages/view', [
            'page_title' => ($page['meta_title'] ?? $page['title']) . ' | Balaji Computech',
            'page'       => $page,
        ]);
    }

    private function getFallbackPages(): array
    {
        return [
            'about-us' => [
                'title'            => 'About Balaji Computech',
                'slug'             => 'about-us',
                'content'          => '<h2>Welcome to Balaji Computech</h2><p>Established as Dewas’s premier IT hardware and technology solutions center, <strong>Balaji Computech</strong> is dedicated to delivering the highest quality computing hardware, custom assembled PC builds, CCTV surveillance setups, and specialized chip-level repair services.</p><h3>Meet the Founder</h3><p>Founded and managed by <strong>Gourav Joshi</strong>, Balaji Computech was created with a mission to bring transparent pricing, genuine computer products, and professional technician support to individual customers, students, freelancers, and businesses across Dewas and Madhya Pradesh.</p><h3>Why Choose Balaji Computech?</h3><ul><li><strong>100% Genuine Products:</strong> Authorized partner for top global brands like HP, Dell, Lenovo, Asus, Intel, CP PLUS, and Hikvision.</li><li><strong>State-of-the-Art Repair Lab:</strong> Advanced BGA soldering and diagnostic equipment for chip-level repair.</li><li><strong>Custom PC Expertise:</strong> Built by gamers and workstation specialists who understand airflow, compatibility, and peak performance.</li><li><strong>Dedicated Customer Care:</strong> Fast inquiry response, WhatsApp support, and post-service warranty assistance.</li></ul>',
                'meta_title'       => 'About Us | Balaji Computech Dewas',
                'meta_description' => 'Learn more about Balaji Computech, founded by Gourav Joshi in Dewas, MP. Your trusted source for laptops, desktops, repairs, and CCTV systems.',
            ],
            'terms-and-conditions' => [
                'title'            => 'Terms & Conditions',
                'slug'             => 'terms-and-conditions',
                'content'          => '<h2>Terms & Conditions</h2><p>Welcome to the Balaji Computech website. By accessing or using this website, you agree to comply with and be bound by the following terms and conditions.</p><h3>1. Website Purpose</h3><p>This website serves as a digital product showcase, service portfolio, and customer inquiry platform. No online payment gateways are integrated, and no monetary transactions take place directly on this website.</p><h3>2. Inquiries and Quotes</h3><p>Submitting an inquiry through this site or communicating via WhatsApp does not constitute a legally binding sales contract until confirmed by Balaji Computech with official quotation and invoice at the shop premises.</p><h3>3. Pricing & Availability</h3><p>Prices and stock availability listed on the website are subject to market fluctuations and distributor changes. We reserve the right to modify prices without prior notice.</p><h3>4. Warranty & Repairs</h3><p>Brand new products carry standard manufacturer warranties. Repaired components carry a 30-day testing warranty unless specified otherwise on the repair job card.</p>',
                'meta_title'       => 'Terms & Conditions | Balaji Computech',
                'meta_description' => 'Read our terms and conditions regarding website usage, product inquiries, quotes, and repair service policies.',
            ],
            'privacy-policy' => [
                'title'            => 'Privacy Policy',
                'slug'             => 'privacy-policy',
                'content'          => '<h2>Privacy Policy</h2><p>At Balaji Computech, we value your trust and are committed to protecting your personal information.</p><h3>Information We Collect</h3><p>When you register an account, add items to your wishlist, or submit an inquiry, we collect information including your name, email address, mobile phone number, and any details you provide in your message.</p><h3>How We Use Your Information</h3><ul><li>To respond to your product and service inquiries promptly.</li><li>To provide quotation details and stock updates via email, phone, or WhatsApp.</li><li>To track your customer service history and support tickets.</li></ul><p>We do not sell, rent, or trade your personal information to any third parties.</p>',
                'meta_title'       => 'Privacy Policy | Balaji Computech',
                'meta_description' => 'Our privacy policy explains how we collect, use, and protect your personal information when you use our website.',
            ],
            'return-and-inquiry-policy' => [
                'title'            => 'Product Inquiry & Return Policy',
                'slug'             => 'return-and-inquiry-policy',
                'content'          => '<h2>Product Inquiry & Return Policy</h2><h3>Inquiry Workflow</h3><p>When you submit an inquiry through our website:</p><ol><li>Our team receives your request and checks live stock availability.</li><li>Gourav Joshi or our service team will reply to your account dashboard and contact you via phone/WhatsApp with current best pricing.</li><li>You can visit our store in Mainashree Complex, Dewas to inspect the hardware, collect the invoice, and pick up your items.</li></ol><h3>Returns & Replacements</h3><p>Since all sales take place directly at our physical store, customers are encouraged to inspect goods before taking delivery. Defective goods under manufacturer warranty will be processed as per official brand service center replacement guidelines.</p>',
                'meta_title'       => 'Inquiry & Return Policy | Balaji Computech',
                'meta_description' => 'Learn how our inquiry system works and our store return and replacement policies.',
            ],
            'disclaimer' => [
                'title'            => 'Disclaimer',
                'slug'             => 'disclaimer',
                'content'          => '<h2>Website Disclaimer</h2><p>All brand logos, trademarks, and product images shown on this website (such as HP, Dell, Lenovo, Asus, Acer, Intel, AMD, CP PLUS, Hikvision, Canon, Epson) are the property of their respective trademark holders. Balaji Computech is an independent retailer and service provider.</p><p>Specifications and images are provided for reference purposes. Please confirm technical details with our team prior to purchase.</p>',
                'meta_title'       => 'Disclaimer | Balaji Computech',
                'meta_description' => 'Legal disclaimer regarding third-party brand trademarks and product specifications.',
            ],
        ];
    }

}
