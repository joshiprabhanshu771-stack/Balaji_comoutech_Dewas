<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactMessageModel extends Model
{
    protected $table            = 'contact_messages';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'email',
        'mobile',
        'subject',
        'message',
        'is_read',
        'created_at',
        'updated_at',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'name'    => 'required|min_length[2]|max_length[100]',
        'email'   => 'required|valid_email|max_length[150]',
        'mobile'  => 'required|indian_mobile',
        'subject' => 'required|min_length[2]|max_length[200]',
        'message' => 'required|min_length[5]',
    ];

    protected $validationMessages = [
        'mobile' => [
            'indian_mobile' => 'Please enter a valid 10-digit Indian mobile number (e.g. 9876543210 or +919876543210).',
        ],
        'email' => [
            'valid_email' => 'Please enter a valid email address.',
        ],
    ];

    /**
     * Safely marks a message as read without throwing exceptions.
     *
     * @param int|string $id
     * @return bool
     */
    public function markAsRead($id): bool
    {
        try {
            return (bool)$this->update($id, [
                'is_read'    => 1,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'ContactMessageModel::markAsRead failed for ID ' . $id . ': ' . $e->getMessage());
            return false;
        }
    }
}
