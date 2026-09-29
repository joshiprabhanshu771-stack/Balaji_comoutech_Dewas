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
        'discount_text',
        'coupon_code',
        'description',
        'banner_image',
        'start_date',
        'end_date',
        'valid_from',
        'valid_until',
        'is_active',
        'status',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    /**
     * Retrieve active promotional offers.
     *
     * @return array
     */
    public function getActiveOffers(): array
    {
        $today = date('Y-m-d');
        return $this->where('is_active', 1)
                    ->where('deleted_at', null)
                    ->groupStart()
                        ->where('end_date >=', $today)
                        ->orWhere('end_date IS NULL')
                    ->groupEnd()
                    ->orderBy('id', 'DESC')
                    ->findAll();
    }
}
