<?php

namespace App\Models;

use CodeIgniter\Model;

class FaqModel extends Model
{
    protected $table            = 'faqs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'category',
        'question',
        'answer',
        'sort_order',
        'is_active',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getActiveFaqsGrouped()
    {
        $faqs = $this->where('is_active', 1)->orderBy('category', 'ASC')->orderBy('sort_order', 'ASC')->findAll();
        $grouped = [];
        foreach ($faqs as $faq) {
            $grouped[$faq['category']][] = $faq;
        }
        return $grouped;
    }
}
