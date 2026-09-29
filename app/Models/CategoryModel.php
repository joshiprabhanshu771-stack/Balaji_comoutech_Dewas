<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'slug',
        'description',
        'image',
        'icon',
        'is_featured',
        'is_active',
        'status',
        'sort_order',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    /**
     * Retrieve all active categories ordered by sort_order and name.
     *
     * @param bool $featuredOnly
     * @return array
     */
    public function getActiveCategories(bool $featuredOnly = false): array
    {
        $builder = $this->where('is_active', 1)->where('deleted_at', null);
        if ($featuredOnly) {
            $builder->where('is_featured', 1);
        }
        return $builder->orderBy('sort_order', 'ASC')->orderBy('name', 'ASC')->findAll();
    }
}
