<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationTokenModel extends Model
{
    protected $table            = 'user_notification_tokens';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'token',
        'device_type',
        'browser',
        'platform',
        'is_active',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Save or update an FCM token for a user.
     * Prevents duplicate active tokens and refreshes device info.
     *
     * @param int $userId
     * @param string $token
     * @param string|null $deviceType
     * @param string|null $browser
     * @param string|null $platform
     * @return int|bool Insert ID or update success status
     */
    public function saveOrUpdateToken(int $userId, string $token, ?string $deviceType = null, ?string $browser = null, ?string $platform = null)
    {
        $token = trim($token);
        if (empty($token)) {
            return false;
        }

        // Check if token already exists
        $existing = $this->where('token', $token)->first();

        $data = [
            'user_id'     => $userId,
            'token'       => $token,
            'device_type' => $deviceType,
            'browser'     => $browser,
            'platform'    => $platform,
            'is_active'   => 1,
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        if ($existing) {
            $this->update($existing['id'], $data);
            return (int)$existing['id'];
        }

        $data['created_at'] = date('Y-m-d H:i:s');
        $newId = $this->insert($data);
        return $newId ? (int)$newId : false;
    }

    /**
     * Get all active FCM tokens for a specific user.
     *
     * @param int $userId
     * @return array List of token strings
     */
    public function getActiveTokensByUser(int $userId): array
    {
        $rows = $this->select('token')
                     ->where('user_id', $userId)
                     ->where('is_active', 1)
                     ->findAll();

        return array_column($rows, 'token');
    }

    /**
     * Get all active FCM tokens for all active administrators (role_id = 1).
     *
     * @return array List of token strings
     */
    public function getActiveAdminTokens(): array
    {
        $rows = $this->select('user_notification_tokens.token')
                     ->join('users', 'users.id = user_notification_tokens.user_id')
                     ->where('users.role_id', 1)
                     ->where('users.status', 'active')
                     ->where('user_notification_tokens.is_active', 1)
                     ->findAll();

        return array_column($rows, 'token');
    }

    /**
     * Deactivate an invalid or expired token.
     *
     * @param string $token
     * @return bool
     */
    public function deactivateToken(string $token): bool
    {
        $token = trim($token);
        if (empty($token)) {
            return false;
        }

        return (bool)$this->where('token', $token)->set(['is_active' => 0, 'updated_at' => date('Y-m-d H:i:s')])->update();
    }

    /**
     * Remove / deactivate a specific token for an authenticated user.
     *
     * @param int $userId
     * @param string $token
     * @return bool
     */
    public function removeUserToken(int $userId, string $token): bool
    {
        $token = trim($token);
        if (empty($token)) {
            return false;
        }

        return (bool)$this->where('user_id', $userId)
                          ->where('token', $token)
                          ->set(['is_active' => 0, 'updated_at' => date('Y-m-d H:i:s')])
                          ->update();
    }

    /**
     * Get count of active tokens for a user.
     *
     * @param int $userId
     * @return int
     */
    public function getActiveTokensCount(int $userId): int
    {
        return $this->where('user_id', $userId)
                    ->where('is_active', 1)
                    ->countAllResults();
    }
}
