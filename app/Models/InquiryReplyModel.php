<?php

namespace App\Models;

use CodeIgniter\Model;

class InquiryReplyModel extends Model
{
    protected $table            = 'inquiry_replies';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'inquiry_id',
        'user_id',
        'message',
        'sent_email',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getRepliesWithUser($inquiryId)
    {
        return $this->select('inquiry_replies.*, users.name as sender_name, roles.name as role_name')
                    ->join('users', 'users.id = inquiry_replies.user_id', 'left')
                    ->join('roles', 'roles.id = users.role_id', 'left')
                    ->where('inquiry_replies.inquiry_id', $inquiryId)
                    ->orderBy('inquiry_replies.id', 'ASC')
                    ->findAll();
    }
}
