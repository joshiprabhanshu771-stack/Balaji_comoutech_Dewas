<?php

namespace App\Libraries;

use App\Models\NotificationTokenModel;
use Config\Firebase as FirebaseConfig;

class FirebaseNotificationService
{
    protected FirebaseConfig $config;
    protected NotificationTokenModel $tokenModel;

    public function __construct(?FirebaseConfig $config = null)
    {
        $this->config     = $config ?? config('Firebase');
        $this->tokenModel = new NotificationTokenModel();
    }

    /**
     * Send push notification to a single token.
     *
     * @param string $token
     * @param string $title
     * @param string $body
     * @param array $data
     * @param array $options
     * @return bool
     */
    public function sendToToken(string $token, string $title, string $body, array $data = [], array $options = []): bool
    {
        $results = $this->sendToTokens([$token], $title, $body, $data, $options);
        return !empty($results['success']) && $results['success'] > 0;
    }

    /**
     * Send push notification to multiple tokens.
     *
     * @param array $tokens List of FCM token strings
     * @param string $title
     * @param string $body
     * @param array $data Custom key-value pairs
     * @param array $options Webpush options (icon, badge, url, tag)
     * @return array Summary of success and failure counts
     */
    public function sendToTokens(array $tokens, string $title, string $body, array $data = [], array $options = []): array
    {
        $uniqueTokens = array_unique(array_filter(array_map('trim', $tokens)));
        if (empty($uniqueTokens)) {
            return ['success' => 0, 'failure' => 0, 'total' => 0];
        }

        $successCount = 0;
        $failureCount = 0;

        foreach ($uniqueTokens as $token) {
            try {
                $sent = $this->dispatchSingleNotification($token, $title, $body, $data, $options);
                if ($sent) {
                    $successCount++;
                } else {
                    $failureCount++;
                }
            } catch (\Throwable $e) {
                $failureCount++;
                log_message('error', 'FCM Send Exception for token [' . substr($token, 0, 12) . '...]: ' . $e->getMessage());
            }
        }

        log_message('info', "FCM dispatch completed. Total: " . count($uniqueTokens) . ", Success: {$successCount}, Failed: {$failureCount}");

        return [
            'success' => $successCount,
            'failure' => $failureCount,
            'total'   => count($uniqueTokens),
        ];
    }

    /**
     * Convenience method: Notify all active Admins about a new customer inquiry.
     *
     * @param array $inquiry
     * @param string|null $itemName
     * @return bool
     */
    public function notifyAdminsOnNewInquiry(array $inquiry, ?string $itemName = null): bool
    {
        try {
            $adminTokens = $this->tokenModel->getActiveAdminTokens();
            if (empty($adminTokens)) {
                log_message('info', 'No active admin FCM tokens registered for inquiry notification.');
                return false;
            }

            $customerName = !empty($inquiry['name']) ? $inquiry['name'] : 'A customer';
            $itemLabel    = $itemName ?: ($inquiry['subject'] ?? 'Product/Service');

            $title = 'New Inquiry - Balaji Computech';
            $body  = "You have received a new inquiry from {$customerName} regarding {$itemLabel}.";

            $targetUrl = base_url('admin/inquiries/' . $inquiry['id']);

            $data = [
                'type'          => 'new_inquiry',
                'inquiry_id'    => (string)$inquiry['id'],
                'inquiry_no'    => (string)($inquiry['inquiry_no'] ?? ''),
                'customer_name' => (string)$customerName,
                'customer_id'   => (string)($inquiry['user_id'] ?? ''),
                'product_id'    => (string)($inquiry['product_id'] ?? ''),
                'service_id'    => (string)($inquiry['service_id'] ?? ''),
                'url'           => $targetUrl,
            ];

            $options = [
                'url'   => $targetUrl,
                'tag'   => 'inquiry-' . $inquiry['id'],
                'icon'  => base_url('favicon.ico'),
                'badge' => base_url('favicon.ico'),
            ];

            $result = $this->sendToTokens($adminTokens, $title, $body, $data, $options);
            return $result['success'] > 0;
        } catch (\Throwable $e) {
            log_message('error', 'Failed to notify admins of new inquiry: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Convenience method: Notify a specific Customer about an inquiry reply.
     *
     * @param array $inquiry
     * @param array $reply
     * @return bool
     */
    public function notifyCustomerOnInquiryReply(array $inquiry, array $reply): bool
    {
        try {
            $customerId = !empty($inquiry['user_id']) ? (int)$inquiry['user_id'] : null;
            if (!$customerId) {
                // Guest inquiry - cannot send FCM token push (email already handled)
                log_message('info', 'Inquiry #' . ($inquiry['inquiry_no'] ?? $inquiry['id']) . ' has no registered customer user_id. Skipping push.');
                return false;
            }

            $customerTokens = $this->tokenModel->getActiveTokensByUser($customerId);
            if (empty($customerTokens)) {
                log_message('info', "Customer ID {$customerId} has no active FCM push tokens registered.");
                return false;
            }

            $title = 'New Reply - Balaji Computech';
            $body  = "Balaji Computech has replied to your inquiry #" . ($inquiry['inquiry_no'] ?? $inquiry['id']) . ".";

            $targetUrl = base_url('dashboard/inquiries/' . $inquiry['id']);

            $data = [
                'type'        => 'inquiry_reply',
                'inquiry_id'  => (string)$inquiry['id'],
                'inquiry_no'  => (string)($inquiry['inquiry_no'] ?? ''),
                'customer_id' => (string)$customerId,
                'reply_id'    => (string)($reply['id'] ?? ''),
                'url'         => $targetUrl,
            ];

            $options = [
                'url'   => $targetUrl,
                'tag'   => 'inquiry-reply-' . $inquiry['id'],
                'icon'  => base_url('favicon.ico'),
                'badge' => base_url('favicon.ico'),
            ];

            $result = $this->sendToTokens($customerTokens, $title, $body, $data, $options);
            return $result['success'] > 0;
        } catch (\Throwable $e) {
            log_message('error', 'Failed to notify customer of inquiry reply: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Internal: Dispatch single message via Firebase HTTP v1 API or Legacy API.
     */
    protected function dispatchSingleNotification(string $token, string $title, string $body, array $data = [], array $options = []): bool
    {
        $accessToken = $this->getOAuth2AccessToken();

        if ($accessToken && !empty($this->config->projectId)) {
            // Firebase HTTP v1 API
            return $this->sendViaHttpV1($accessToken, $this->config->projectId, $token, $title, $body, $data, $options);
        }

        if (!empty($this->config->serverKey)) {
            // Fallback: Legacy FCM API
            return $this->sendViaLegacyApi($this->config->serverKey, $token, $title, $body, $data, $options);
        }

        log_message('warning', 'Firebase FCM is not fully configured with service account credentials or server key. Message not sent.');
        return false;
    }

    /**
     * Send via Firebase Cloud Messaging HTTP v1 API.
     */
    protected function sendViaHttpV1(string $accessToken, string $projectId, string $token, string $title, string $body, array $data = [], array $options = []): bool
    {
        $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

        $targetUrl = $options['url'] ?? base_url('/');
        $iconUrl   = $options['icon'] ?? base_url('favicon.ico');
        $badgeUrl  = $options['badge'] ?? base_url('favicon.ico');
        $tag       = $options['tag'] ?? 'balaji-notice-' . time();

        // Stringify all data values for FCM v1 requirement
        $stringData = [];
        foreach ($data as $k => $v) {
            $stringData[(string)$k] = (string)$v;
        }

        $payload = [
            'message' => [
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body'  => $body,
                ],
                'data' => $stringData,
                'webpush' => [
                    'headers' => [
                        'Urgency' => 'high',
                        'TTL'     => '86400',
                    ],
                    'notification' => [
                        'title'              => $title,
                        'body'               => $body,
                        'icon'               => $iconUrl,
                        'badge'              => $badgeUrl,
                        'tag'                => $tag,
                        'renotify'           => true,
                        'requireInteraction' => false,
                        'data'               => array_merge($stringData, ['url' => $targetUrl]),
                    ],
                    'fcm_options' => [
                        'link' => $targetUrl,
                    ],
                ],
            ],
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json; UTF-8',
            ],
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_TIMEOUT        => 10,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErr  = curl_error($ch);
        curl_close($ch);

        if ($curlErr) {
            log_message('error', 'FCM HTTP v1 cURL error: ' . $curlErr);
            return false;
        }

        if ($httpCode === 200) {
            return true;
        }

        // Handle error responses & invalid tokens
        $json = json_decode($response, true);
        $errorCode = $json['error']['details'][0]['errorCode'] ?? ($json['error']['status'] ?? '');
        $errorMessage = $json['error']['message'] ?? $response;

        log_message('warning', "FCM HTTP v1 error ({$httpCode}): {$errorMessage}");

        if (in_array($errorCode, ['UNREGISTERED', 'NOT_FOUND', 'INVALID_ARGUMENT'], true) ||
            stripos($errorMessage, 'Requested entity was not found') !== false ||
            stripos($errorMessage, 'registration-token-not-registered') !== false) {
            $this->tokenModel->deactivateToken($token);
            log_message('info', 'Deactivated unregistered/invalid FCM token: ' . substr($token, 0, 15) . '...');
        }

        return false;
    }

    /**
     * Send via FCM Legacy API (fallback if server key is configured).
     */
    protected function sendViaLegacyApi(string $serverKey, string $token, string $title, string $body, array $data = [], array $options = []): bool
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $targetUrl = $options['url'] ?? base_url('/');
        $iconUrl   = $options['icon'] ?? base_url('favicon.ico');

        $payload = [
            'to'           => $token,
            'notification' => [
                'title'        => $title,
                'body'         => $body,
                'icon'         => $iconUrl,
                'click_action' => $targetUrl,
            ],
            'data' => array_merge($data, ['url' => $targetUrl]),
            'priority' => 'high',
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => [
                'Authorization: key=' . $serverKey,
                'Content-Type: application/json',
            ],
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_TIMEOUT        => 10,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErr  = curl_error($ch);
        curl_close($ch);

        if ($curlErr) {
            log_message('error', 'FCM Legacy cURL error: ' . $curlErr);
            return false;
        }

        if ($httpCode === 200) {
            $json = json_decode($response, true);
            if (!empty($json['results'][0]['error'])) {
                $err = $json['results'][0]['error'];
                if (in_array($err, ['NotRegistered', 'InvalidRegistration'], true)) {
                    $this->tokenModel->deactivateToken($token);
                    log_message('info', "Deactivated {$err} FCM token.");
                }
                return false;
            }
            return true;
        }

        log_message('warning', "FCM Legacy error ({$httpCode}): {$response}");
        return false;
    }

    /**
     * Generate or retrieve cached OAuth2 access token for Firebase HTTP v1 API.
     */
    protected function getOAuth2AccessToken(): ?string
    {
        $cacheKey = 'fcm_oauth2_access_token_' . md5($this->config->projectId . $this->config->clientEmail);
        
        try {
            $cached = cache($cacheKey);
            if ($cached) {
                return $cached;
            }
        } catch (\Throwable $e) {
            // Ignore cache read failures
        }

        $credentials = $this->loadServiceAccountCredentials();
        if (!$credentials) {
            return null;
        }

        $clientEmail = $credentials['client_email'] ?? '';
        $privateKey  = $credentials['private_key'] ?? '';

        if (empty($clientEmail) || empty($privateKey)) {
            return null;
        }

        // Generate JWT
        $now = time();
        $header = ['alg' => 'RS256', 'typ' => 'JWT'];
        $claimSet = [
            'iss'   => $clientEmail,
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud'   => 'https://oauth2.googleapis.com/token',
            'exp'   => $now + 3600,
            'iat'   => $now,
        ];

        $base64Header   = $this->base64UrlEncode(json_encode($header));
        $base64ClaimSet = $this->base64UrlEncode(json_encode($claimSet));
        $signatureInput = $base64Header . '.' . $base64ClaimSet;

        $signature = '';
        $binaryKey = openssl_pkey_get_private($privateKey);
        if (!$binaryKey) {
            log_message('error', 'Failed to load Firebase private key. Check formatting.');
            return null;
        }

        $success = openssl_sign($signatureInput, $signature, $binaryKey, OPENSSL_ALGO_SHA256);
        if (!$success) {
            log_message('error', 'Failed to sign JWT for Google OAuth2 token exchange.');
            return null;
        }

        $jwt = $signatureInput . '.' . $this->base64UrlEncode($signature);

        // Exchange JWT for OAuth2 Access Token
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => 'https://oauth2.googleapis.com/token',
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/x-www-form-urlencoded'],
            CURLOPT_POSTFIELDS     => http_build_query([
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion'  => $jwt,
            ]),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_TIMEOUT        => 10,
        ]);

        $res      = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && $res) {
            $json = json_decode($res, true);
            if (!empty($json['access_token'])) {
                $token = $json['access_token'];
                $ttl   = max(60, (int)($json['expires_in'] ?? 3600) - 300); // 55 mins
                try {
                    cache()->save($cacheKey, $token, $ttl);
                } catch (\Throwable $e) {
                    // Cache save fallback
                }
                return $token;
            }
        }

        log_message('error', "Google OAuth2 token exchange failed ({$httpCode}): {$res}");
        return null;
    }

    /**
     * Load service account credentials from file path or individual config fields.
     */
    protected function loadServiceAccountCredentials(): ?array
    {
        // 1. From file path if configured
        if (!empty($this->config->credentialsPath)) {
            $path = $this->config->credentialsPath;
            if (!is_file($path)) {
                $path = ROOTPATH . ltrim($this->config->credentialsPath, '/\\');
            }
            if (is_file($path) && is_readable($path)) {
                $contents = file_get_contents($path);
                $json = json_decode($contents, true);
                if (is_array($json) && !empty($json['private_key'])) {
                    if (empty($this->config->projectId) && !empty($json['project_id'])) {
                        $this->config->projectId = $json['project_id'];
                    }
                    return $json;
                }
            }
        }

        // 2. From individual config / env values
        if (!empty($this->config->clientEmail) && !empty($this->config->privateKey)) {
            // Ensure proper newline formatting in private key if passed as single line in .env
            $privateKey = str_replace('\\n', "\n", $this->config->privateKey);
            return [
                'client_email' => $this->config->clientEmail,
                'private_key'  => $privateKey,
                'project_id'   => $this->config->projectId,
            ];
        }

        return null;
    }

    protected function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}
