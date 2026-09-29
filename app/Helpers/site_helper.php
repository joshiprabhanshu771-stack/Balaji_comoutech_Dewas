<?php

if (!function_exists('get_setting')) {
    /**
     * Retrieve a site setting value by key with optional default fallback.
     *
     * @param string $key
     * @param mixed $default
     * @param bool $refresh
     * @return mixed
     */
    function get_setting(string $key, $default = null, bool $refresh = false)
    {
        static $settings = null;
        if ($settings === null || $refresh) {
            try {
                $settingModel = new \App\Models\SettingModel();
                $settings = $settingModel->getAllAsMap();
            } catch (\Throwable $e) {
                log_message('error', 'Error loading settings in get_setting: ' . $e->getMessage());
                return $default;
            }
        }
        return $settings[$key] ?? $default;
    }
}

if (!function_exists('format_price')) {
    /**
     * Format currency amount in Indian Rupees (INR).
     *
     * @param mixed $amount
     * @return string
     */
    function format_price($amount)
    {
        if ($amount === null || $amount === '') {
            return 'Contact for Price';
        }
        return '₹' . number_format((float)$amount, 2);
    }
}

if (!function_exists('normalize_indian_mobile')) {
    /**
     * Normalizes an Indian mobile number into strict +91XXXXXXXXXX format (13 characters).
     *
     * Validates that the 10-digit base number starts with 6, 7, 8, or 9.
     * Rejects numbers with extra digits, fewer digits, invalid characters, or invalid prefixes.
     *
     * @param string|null $mobile
     * @return string|null Normalized number '+91XXXXXXXXXX' or null if invalid.
     */
    function normalize_indian_mobile(?string $mobile): ?string
    {
        if ($mobile === null) {
            return null;
        }

        $clean = trim($mobile);
        if ($clean === '') {
            return null;
        }

        // Check for multiple '+' signs
        if (substr_count($clean, '+') > 1) {
            return null;
        }

        $hasPlus = str_starts_with($clean, '+');

        // Remove allowed formatting chars: spaces, dashes, parentheses, dots
        $stripped = preg_replace('/[\s\-\(\)\.]/', '', $clean);

        // If there was a '+' not at the start, invalid
        if (str_contains($stripped, '+') && !$hasPlus) {
            return null;
        }

        $digits = str_replace('+', '', $stripped);

        // Ensure purely numeric digits
        if (!ctype_digit($digits)) {
            return null;
        }

        // Case 1: 10 digits -> e.g. 9876543210
        if (strlen($digits) === 10) {
            if ($hasPlus) {
                // Cannot be +9876543210 without country code 91
                return null;
            }
            if (preg_match('/^[6-9]\d{9}$/', $digits)) {
                return '+91' . $digits;
            }
            return null;
        }

        // Case 2: 11 digits starting with '0' -> e.g. 09876543210
        if (strlen($digits) === 11 && str_starts_with($digits, '0')) {
            if ($hasPlus) {
                return null;
            }
            $base = substr($digits, 1);
            if (preg_match('/^[6-9]\d{9}$/', $base)) {
                return '+91' . $base;
            }
            return null;
        }

        // Case 3: 12 digits starting with '91' -> e.g. 919876543210 or +919876543210
        if (strlen($digits) === 12 && str_starts_with($digits, '91')) {
            $base = substr($digits, 2);
            if (preg_match('/^[6-9]\d{9}$/', $base)) {
                return '+91' . $base;
            }
            return null;
        }

        return null;
    }
}

if (!function_exists('validate_indian_mobile')) {
    /**
     * Checks if a mobile number is a valid Indian mobile number.
     *
     * @param string|null $mobile
     * @return bool
     */
    function validate_indian_mobile(?string $mobile): bool
    {
        return normalize_indian_mobile($mobile) !== null;
    }
}

if (!function_exists('format_indian_mobile')) {
    /**
     * Returns formatted display for Indian mobile number: +91 98765 43210 or +919876543210.
     *
     * @param string|null $mobile
     * @param bool $spaced
     * @return string
     */
    function format_indian_mobile(?string $mobile, bool $spaced = true): string
    {
        $normalized = normalize_indian_mobile($mobile);
        if (!$normalized) {
            return (string)($mobile ?? '');
        }

        if ($spaced && strlen($normalized) === 13) {
            // +91 98765 43210
            return substr($normalized, 0, 3) . ' ' . substr($normalized, 3, 5) . ' ' . substr($normalized, 8);
        }

        return $normalized;
    }
}

if (!function_exists('get_whatsapp_url')) {
    /**
     * Generates a direct WhatsApp click-to-chat URL with safe phone number normalization.
     *
     * @param string $customMessage
     * @param string $phone
     * @return string
     */
    function get_whatsapp_url(string $customMessage = '', string $phone = ''): string
    {
        if (empty($phone)) {
            $phone = (string)get_setting('whatsapp_number', '+919826012345');
        }

        $normalized = normalize_indian_mobile($phone);
        if ($normalized) {
            // wa.me requires digits without '+' (e.g. 919826012345)
            $phoneDigits = ltrim($normalized, '+');
        } else {
            $phoneDigits = preg_replace('/[^0-9]/', '', $phone);
            if (strlen($phoneDigits) === 10) {
                $phoneDigits = '91' . $phoneDigits;
            }
        }

        $encodedMessage = urlencode($customMessage);
        return "https://wa.me/{$phoneDigits}?text={$encodedMessage}";
    }
}

if (!function_exists('current_user')) {
    /**
     * Returns the currently logged in user session data or null.
     *
     * @return array|null
     */
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
    /**
     * Check if currently logged in user is an Administrator (role_id = 1).
     *
     * @return bool
     */
    function is_admin()
    {
        $session = session();
        return $session->get('isLoggedIn') && (int)$session->get('role_id') === 1;
    }
}

if (!function_exists('is_customer')) {
    /**
     * Check if currently logged in user is a Customer (role_id = 2).
     *
     * @return bool
     */
    function is_customer()
    {
        $session = session();
        return $session->get('isLoggedIn') && (int)$session->get('role_id') === 2;
    }
}
