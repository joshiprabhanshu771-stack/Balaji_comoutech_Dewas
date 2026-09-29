<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public Frontend Routes
$routes->get('/', 'Home::index');
$routes->get('our-presence', 'Home::presence');
$routes->get('presence', 'Home::presence');
$routes->get('store-location', 'Home::presence');

// Products
$routes->get('products', 'Product::index');
$routes->get('products/(:segment)', 'Product::detail/$1');

// Services
$routes->get('services', 'Service::index');
$routes->get('services/(:segment)', 'Service::detail/$1');

// Brands
$routes->get('brands', 'Brand::index');
$routes->get('brands/(:segment)', 'Brand::detail/$1');

// Offers & Deals
$routes->get('offers', 'Offer::index');

// FAQs
$routes->get('faq', 'Faq::index');
$routes->get('faqs', 'Faq::index');

// Contact Us
$routes->get('contact', 'Contact::index');
$routes->post('contact/submit', 'Contact::submit');

// Inquiry Submission
$routes->post('inquiry/submit', 'Inquiry::submit');

// Static / Content Pages
$routes->get('page/(:segment)', 'Page::view/$1');
$routes->get('pages/(:segment)', 'Page::view/$1');
$routes->get('about-us', 'Page::view/about-us');
$routes->get('terms-and-conditions', 'Page::view/terms-and-conditions');
$routes->get('privacy-policy', 'Page::view/privacy-policy');
$routes->get('return-and-inquiry-policy', 'Page::view/return-and-inquiry-policy');
$routes->get('disclaimer', 'Page::view/disclaimer');


// Authentication Routes
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/login', 'Auth::attemptLogin');
$routes->get('auth/register', 'Auth::register');
$routes->post('auth/register', 'Auth::attemptRegister');
$routes->get('auth/logout', 'Auth::logout');

// Wishlist (AJAX toggle & remove)
$routes->post('wishlist/toggle', 'Wishlist::toggle');
$routes->get('wishlist/remove/(:num)', 'Wishlist::remove/$1');

// Customer Protected Routes
$routes->group('dashboard', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/', 'Customer\Dashboard::index');
    $routes->get('profile', 'Customer\Profile::index');
    $routes->post('profile/update', 'Customer\Profile::update');
    $routes->post('profile/change-password', 'Customer\Profile::changePassword');
    $routes->get('inquiries', 'Customer\Inquiry::index');
    $routes->get('inquiries/(:num)', 'Customer\Inquiry::detail/$1');
    $routes->get('wishlist', 'Customer\Wishlist::index');
});

// Admin Protected Routes
$routes->group('admin', ['filter' => 'admin'], static function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->get('dashboard', 'Admin\Dashboard::index');

    // Products Management
    $routes->get('products', 'Admin\ProductController::index');
    $routes->get('products/create', 'Admin\ProductController::create');
    $routes->post('products/store', 'Admin\ProductController::store');
    $routes->get('products/edit/(:num)', 'Admin\ProductController::edit/$1');
    $routes->post('products/update/(:num)', 'Admin\ProductController::update/$1');
    $routes->get('products/delete/(:num)', 'Admin\ProductController::delete/$1');

    // Categories Management
    $routes->get('categories', 'Admin\CategoryController::index');
    $routes->get('categories/create', 'Admin\CategoryController::create');
    $routes->post('categories/store', 'Admin\CategoryController::store');
    $routes->get('categories/edit/(:num)', 'Admin\CategoryController::edit/$1');
    $routes->post('categories/update/(:num)', 'Admin\CategoryController::update/$1');
    $routes->get('categories/delete/(:num)', 'Admin\CategoryController::delete/$1');

    // Brands Management
    $routes->get('brands', 'Admin\BrandController::index');
    $routes->get('brands/create', 'Admin\BrandController::create');
    $routes->post('brands/store', 'Admin\BrandController::store');
    $routes->get('brands/edit/(:num)', 'Admin\BrandController::edit/$1');
    $routes->post('brands/update/(:num)', 'Admin\BrandController::update/$1');
    $routes->get('brands/delete/(:num)', 'Admin\BrandController::delete/$1');

    // Services Management
    $routes->get('services', 'Admin\ServiceController::index');
    $routes->get('services/create', 'Admin\ServiceController::create');
    $routes->post('services/store', 'Admin\ServiceController::store');
    $routes->get('services/edit/(:num)', 'Admin\ServiceController::edit/$1');
    $routes->post('services/update/(:num)', 'Admin\ServiceController::update/$1');
    $routes->get('services/delete/(:num)', 'Admin\ServiceController::delete/$1');

    // Inquiry Management
    $routes->get('inquiries', 'Admin\InquiryController::index');
    $routes->get('inquiries/(:num)', 'Admin\InquiryController::detail/$1');
    $routes->post('inquiries/reply/(:num)', 'Admin\InquiryController::reply/$1');
    $routes->post('inquiries/update-status/(:num)', 'Admin\InquiryController::updateStatus/$1');
    $routes->get('inquiries/delete/(:num)', 'Admin\InquiryController::delete/$1');

    // Contact Messages
    $routes->get('contact-messages', 'Admin\ContactController::index');
    $routes->get('contact-messages/(:num)', 'Admin\ContactController::detail/$1');
    $routes->get('contact-messages/delete/(:num)', 'Admin\ContactController::delete/$1');

    // Offers
    $routes->get('offers', 'Admin\OfferController::index');
    $routes->get('offers/create', 'Admin\OfferController::create');
    $routes->post('offers/store', 'Admin\OfferController::store');
    $routes->get('offers/edit/(:num)', 'Admin\OfferController::edit/$1');
    $routes->post('offers/update/(:num)', 'Admin\OfferController::update/$1');
    $routes->get('offers/delete/(:num)', 'Admin\OfferController::delete/$1');

    // FAQs
    $routes->get('faqs', 'Admin\FaqController::index');
    $routes->get('faqs/create', 'Admin\FaqController::create');
    $routes->post('faqs/store', 'Admin\FaqController::store');
    $routes->get('faqs/edit/(:num)', 'Admin\FaqController::edit/$1');
    $routes->post('faqs/update/(:num)', 'Admin\FaqController::update/$1');
    $routes->get('faqs/delete/(:num)', 'Admin\FaqController::delete/$1');

    // Pages
    $routes->get('pages', 'Admin\PageController::index');
    $routes->get('pages/create', 'Admin\PageController::create');
    $routes->post('pages/store', 'Admin\PageController::store');
    $routes->get('pages/edit/(:num)', 'Admin\PageController::edit/$1');
    $routes->post('pages/update/(:num)', 'Admin\PageController::update/$1');
    $routes->get('pages/delete/(:num)', 'Admin\PageController::delete/$1');

    // Presence / Store Info
    $routes->get('presence', 'Admin\PresenceController::index');
    $routes->get('presence/edit/(:num)', 'Admin\PresenceController::edit/$1');
    $routes->post('presence/update/(:num)', 'Admin\PresenceController::update/$1');

    // Users Management
    $routes->get('users', 'Admin\UserController::index');
    $routes->get('users/edit/(:num)', 'Admin\UserController::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\UserController::update/$1');

    // Settings
    $routes->get('settings', 'Admin\SettingController::index');
    $routes->post('settings/update', 'Admin\SettingController::update');
});

// Push Notification Routes
$routes->get('notifications/config', 'NotificationController::config');
$routes->post('notifications/register-token', 'NotificationController::registerToken');
$routes->post('notifications/remove-token', 'NotificationController::removeToken');
$routes->get('notifications/status', 'NotificationController::status');
$routes->post('notifications/send-test', 'NotificationController::sendTest');

