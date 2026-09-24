<?php

namespace App\Models;

use CodeIgniter\Model;

class OfferModel extends Model
{
    protected $table            = 'offers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title',
        'slug',
        'description',
        'banner_image',
        'discount_text',
        'coupon_code',
        'valid_from',
        'valid_until',
        'is_active',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getActiveOffers()
    {
        $today = date('Y-m-d');
        return $this->where('is_active', 1)
                    ->groupStart()
                        ->where('valid_until >=', $today)
                        ->orWhere('valid_until IS NULL')
                    ->groupEnd()
                    ->orderBy('id', 'DESC')
                    ->findAll();
    }
}
