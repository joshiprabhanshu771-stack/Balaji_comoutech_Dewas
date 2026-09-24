<?php

namespace App\Controllers;

use App\Models\NotificationTokenModel;
use App\Libraries\FirebaseNotificationService;
use Config\Firebase as FirebaseConfig;

class NotificationController extends BaseController
{
    protected NotificationTokenModel $tokenModel;
    protected FirebaseNotificationService $firebaseService;

    public function __construct()
    {
        $this->tokenModel      = new NotificationTokenModel();
        $this->firebaseService = new FirebaseNotificationService();
    }

    /**
     * Return public Firebase Web SDK configuration.
     */
    public function config()
    {
        $firebaseConfig = config('Firebase');
        return $this->response->setJSON([
            'status' => 'success',
            'config' => $firebaseConfig->getPublicConfig(),
        ]);
    }

    /**
     * Register or update an FCM token for the currently authenticated user.
     */
    public function registerToken()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setStatusCode(401)->setJSON([
                'status'  => 'error',
                'message' => 'Authentication required to register push notification token.',
            ]);
        }

        $userId = (int)session()->get('user_id');
        $token  = trim($this->request->getPost('token') ?? '');

        if (empty($token) || strlen($token) < 20) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 'error',
                'message' => 'Valid FCM registration token is required.',
            ]);
        }

        $deviceType = trim($this->request->getPost('device_type') ?? '');
        $browser    = trim($this->request->getPost('browser') ?? '');
        $platform   = trim($this->request->getPost('platform') ?? '');

        // Auto-detect from User Agent if not provided
        if (empty($browser) || empty($platform) || empty($deviceType)) {
            $agent = $this->request->getUserAgent();
            if ($agent) {
                $browser    = $browser ?: $agent->getBrowser() . ' ' . $agent->getVersion();
                $platform   = $platform ?: $agent->getPlatform();
                $deviceType = $deviceType ?: ($agent->isMobile() ? 'mobile' : ($agent->isRobot() ? 'bot' : 'desktop'));
            }
        }

        $savedId = $this->tokenModel->saveOrUpdateToken($userId, $token, $deviceType, $browser, $platform);

        if ($savedId) {
            log_message('info', "FCM Token registered for user_id {$userId} ({$deviceType}/{$browser}).");
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Push notifications enabled successfully for this device.',
            ]);
        }

        return $this->response->setStatusCode(500)->setJSON([
            'status'  => 'error',
            'message' => 'Failed to save notification token.',
        ]);
    }

    /**
     * Unsubscribe / deactivate a token for the currently authenticated user.
     */
    public function removeToken()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setStatusCode(401)->setJSON([
                'status'  => 'error',
                'message' => 'Authentication required.',
            ]);
        }

        $userId = (int)session()->get('user_id');
        $token  = trim($this->request->getPost('token') ?? '');

        if (!empty($token)) {
            $this->tokenModel->removeUserToken($userId, $token);
            log_message('info', "FCM Token deactivated for user_id {$userId}.");
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Push notifications disabled for this device.',
        ]);
    }

    /**
     * Return notification subscription status for the current user.
     */
    public function status()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON([
                'is_logged_in'         => false,
                'active_devices_count' => 0,
            ]);
        }

        $userId = (int)session()->get('user_id');
        $count  = $this->tokenModel->getActiveTokensCount($userId);

        return $this->response->setJSON([
            'is_logged_in'         => true,
            'user_id'              => $userId,
            'user_name'            => session()->get('user_name'),
            'role_id'              => (int)session()->get('role_id'),
            'active_devices_count' => $count,
        ]);
    }

    /**
     * Send an immediate test notification to the authenticated user's active device(s).
     */
    public function sendTest()
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setStatusCode(401)->setJSON([
                'status'  => 'error',
                'message' => 'Please log in to send a test notification.',
            ]);
        }

        $userId = (int)session()->get('user_id');
        $tokens = $this->tokenModel->getActiveTokensByUser($userId);

        if (empty($tokens)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'No active notification tokens found for your account. Please enable notifications on this device first.',
            ]);
        }

        $roleName = (int)session()->get('role_id') === 1 ? 'Shopkeeper / Admin' : 'Customer';
        $title    = 'Test Alert - Balaji Computech';
        $body     = "Hello " . session()->get('user_name') . "! Push notifications are configured and working perfectly for {$roleName}.";
        $url      = (int)session()->get('role_id') === 1 ? base_url('admin/dashboard') : base_url('dashboard');

        $result = $this->firebaseService->sendToTokens($tokens, $title, $body, [
            'type' => 'test_alert',
            'url'  => $url,
        ], [
            'url'   => $url,
            'tag'   => 'test-' . time(),
            'icon'  => base_url('favicon.ico'),
            'badge' => base_url('favicon.ico'),
        ]);

        if ($result['success'] > 0) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => "Test push notification sent successfully to {$result['success']} active device(s).",
                'details' => $result,
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Could not deliver test notification to FCM. Please ensure Firebase Service Account / Server Key is configured in .env.',
            'details' => $result,
        ]);
    }
}
