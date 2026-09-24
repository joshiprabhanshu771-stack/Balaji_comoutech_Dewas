<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Firebase extends BaseConfig
{
    /**
     * Firebase Web SDK Configuration (Public values for browser client)
     */
    public string $apiKey            = '';
    public string $authDomain        = '';
    public string $projectId         = '';
    public string $storageBucket     = '';
    public string $messagingSenderId = '';
    public string $appId             = '';
    public string $vapidKey          = '';

    /**
     * Firebase Server / Admin Credentials (STRICTLY PRIVATE - Never exposed to frontend)
     */
    public string $credentialsPath = '';
    public string $clientEmail     = '';
    public string $privateKey      = '';
    public string $serverKey       = ''; // Legacy fallback if configured

    public function __construct()
    {
        parent::__construct();

        if (!function_exists('get_setting')) {
            helper('site');
        }

        $getSettingVal = function (string $key, $default = '') {
            if (function_exists('get_setting')) {
                return \get_setting($key, $default);
            }
            return $default;
        };

        // Web App Client Settings (Env variables with database setting fallback)
        $this->apiKey            = (string)env('firebase.web.api.key', env('FIREBASE_WEB_API_KEY', $getSettingVal('firebase_web_api_key', '')));
        $this->authDomain        = (string)env('firebase.web.auth.domain', env('FIREBASE_WEB_AUTH_DOMAIN', $getSettingVal('firebase_web_auth_domain', '')));
        $this->projectId         = (string)env('firebase.project.id', env('FIREBASE_PROJECT_ID', env('firebase.web.project.id', $getSettingVal('firebase_project_id', ''))));
        $this->storageBucket     = (string)env('firebase.web.storage.bucket', env('FIREBASE_WEB_STORAGE_BUCKET', $getSettingVal('firebase_web_storage_bucket', '')));
        $this->messagingSenderId = (string)env('firebase.web.messaging.sender.id', env('FIREBASE_WEB_MESSAGING_SENDER_ID', $getSettingVal('firebase_web_messaging_sender_id', '')));
        $this->appId             = (string)env('firebase.web.app.id', env('FIREBASE_WEB_APP_ID', $getSettingVal('firebase_web_app_id', '')));
        $this->vapidKey          = (string)env('firebase.web.vapid.key', env('FIREBASE_WEB_VAPID_KEY', $getSettingVal('firebase_web_vapid_key', '')));

        // Server-Side Sending Credentials
        $this->credentialsPath = (string)env('firebase.credentials.path', env('FIREBASE_CREDENTIALS_PATH', ''));
        $this->clientEmail     = (string)env('firebase.client.email', env('FIREBASE_CLIENT_EMAIL', ''));
        $this->privateKey      = (string)env('firebase.private.key', env('FIREBASE_PRIVATE_KEY', ''));
        $this->serverKey       = (string)env('firebase.server.key', env('FIREBASE_SERVER_KEY', ''));
    }

    /**
     * Get public web configuration array for frontend SDK initialization.
     *
     * @return array
     */
    public function getPublicConfig(): array
    {
        return [
            'apiKey'            => $this->apiKey,
            'authDomain'        => $this->authDomain,
            'projectId'         => $this->projectId,
            'storageBucket'     => $this->storageBucket,
            'messagingSenderId' => $this->messagingSenderId,
            'appId'             => $this->appId,
            'vapidKey'          => $this->vapidKey,
        ];
    }
}
