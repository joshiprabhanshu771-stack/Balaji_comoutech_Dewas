<?php

if (!function_exists('get_setting')) {
    function get_setting(string $key, $default = null)
    {
        static $settings = null;
        if ($settings === null) {
            $settingModel = new \App\Models\SettingModel();
            $settings = $settingModel->getAllAsMap();
        }
        return $settings[$key] ?? $default;
    }
}

if (!function_exists('format_price')) {
    function format_price($amount)
    {
        if ($amount === null || $amount === '') {
            return 'Contact for Price';
        }
        return '₹' . number_format((float)$amount, 2);
    }
}

if (!function_exists('get_whatsapp_url')) {
    function get_whatsapp_url(string $customMessage = '', string $phone = '')
    {
        if (empty($phone)) {
            $phone = get_setting('whatsapp_number', '919826012345');
        }
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($phone) === 10) {
            $phone = '91' . $phone;
        }
        $encodedMessage = urlencode($customMessage);
        return "https://wa.me/{$phone}?text={$encodedMessage}";
    }
}

if (!function_exists('current_user')) {
    function current_user()
    {
        $session = session();
        if ($session->get('isLoggedIn')) {
            return [
                'id'        => $session->get('user_id'),
                'name'      => $session->get('user_name'),
                'email'     => $session->get('user_email'),
                'role_id'   => $session->get('role_id'),
                'role_name' => $session->get('role_name'),
            ];
        }
        return null;
    }
}

if (!function_exists('is_admin')) {
    function is_admin()
    {
        $session = session();
        return $session->get('isLoggedIn') && (int)$session->get('role_id') === 1;
    }
}

if (!function_exists('is_customer')) {
    function is_customer()
    {
        $session = session();
        return $session->get('isLoggedIn') && (int)$session->get('role_id') === 2;
    }
}
