<?php

namespace App\Models;

use CodeIgniter\Model;

class InquiryModel extends Model
{
    protected $table            = 'inquiries';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'inquiry_no',
        'user_id',
        'product_id',
        'service_id',
        'name',
        'email',
        'mobile',
        'subject',
        'message',
        'inquiry_type',
        'status',
        'admin_notes',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function generateInquiryNumber()
    {
        $prefix = 'BC-INQ-' . date('Ymd');
        $random = strtoupper(substr(bin2hex(random_bytes(3)), 0, 4));
        return $prefix . '-' . $random;
    }

    public function getInquiriesWithDetails($filters = [], $limit = null, $offset = 0)
    {
        $builder = $this->select('inquiries.*, products.name as product_name, products.slug as product_slug, services.name as service_name, services.slug as service_slug, users.name as user_account_name')
                        ->join('products', 'products.id = inquiries.product_id', 'left')
                        ->join('services', 'services.id = inquiries.service_id', 'left')
                        ->join('users', 'users.id = inquiries.user_id', 'left');

        if (!empty($filters['user_id'])) {
            $builder->where('inquiries.user_id', $filters['user_id']);
        }
        if (!empty($filters['status'])) {
            $builder->where('inquiries.status', $filters['status']);
        }
        if (!empty($filters['inquiry_type'])) {
            $builder->where('inquiries.inquiry_type', $filters['inquiry_type']);
        }
        if (!empty($filters['search'])) {
            $builder->groupStart()
                    ->like('inquiries.inquiry_no', $filters['search'])
                    ->orLike('inquiries.name', $filters['search'])
                    ->orLike('inquiries.email', $filters['search'])
                    ->orLike('inquiries.mobile', $filters['search'])
                    ->orLike('inquiries.subject', $filters['search'])
                    ->groupEnd();
        }

        $builder->orderBy('inquiries.id', 'DESC');

        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        return $builder->findAll();
    }

    public function getInquiryDetail($id)
    {
        return $this->select('inquiries.*, products.name as product_name, products.slug as product_slug, products.main_image as product_image, products.price as product_price, services.name as service_name, services.slug as service_slug, services.icon as service_icon')
                    ->join('products', 'products.id = inquiries.product_id', 'left')
                    ->join('services', 'services.id = inquiries.service_id', 'left')
                    ->where('inquiries.id', $id)
                    ->first();
    }
}
