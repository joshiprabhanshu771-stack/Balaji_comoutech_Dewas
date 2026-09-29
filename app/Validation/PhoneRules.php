<?php

namespace App\Validation;

class PhoneRules
{
    /**
     * Validates that the input is a valid Indian mobile number.
     * Accepts:
     * - 10 digits starting with 6, 7, 8, 9 (e.g. 9876543210)
     * - 11 digits starting with 0 followed by 6-9 (e.g. 09876543210)
     * - 12 digits starting with 91 followed by 6-9 (e.g. 919876543210)
     * - 13 characters starting with +91 followed by 6-9 (e.g. +919876543210 or +91 98765 43210)
     *
     * @param string|null $value
     * @param string|null $error
     * @return bool
     */
    public function indian_mobile(?string $value, ?string &$error = null): bool
    {
        if ($value === null || trim($value) === '') {
            return false;
        }

        if (!function_exists('validate_indian_mobile')) {
            if (function_exists('helper')) {
                helper('site');
            } else {
                $helperPath = APPPATH . 'Helpers/site_helper.php';
                if (is_file($helperPath)) {
                    require_once $helperPath;
                }
            }
        }

        if (function_exists('validate_indian_mobile')) {
            if (!validate_indian_mobile($value)) {
                $error = 'The {field} field must be a valid 10-digit Indian mobile number (e.g., 9876543210 or +919876543210).';
                return false;
            }
            return true;
        }

        // Direct fallback validation if helper not found
        $clean = preg_replace('/[\s\-\(\)\.]/', '', trim($value));
        $digits = str_replace('+', '', $clean);
        if (strlen($digits) === 10 && preg_match('/^[6-9]\d{9}$/', $digits)) {
            return true;
        }
        if (strlen($digits) === 12 && str_starts_with($digits, '91') && preg_match('/^[6-9]\d{9}$/', substr($digits, 2))) {
            return true;
        }
        if (strlen($digits) === 11 && str_starts_with($digits, '0') && preg_match('/^[6-9]\d{9}$/', substr($digits, 1))) {
            return true;
        }

        $error = 'The {field} field must be a valid 10-digit Indian mobile number (e.g., 9876543210 or +919876543210).';
        return false;
    }
}
