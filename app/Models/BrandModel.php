<?php

namespace App\Models;

use CodeIgniter\Model;

class BrandModel extends Model
{
    protected $table            = 'brands';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'slug',
        'logo',
        'description',
        'website',
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
     * Retrieve all active brands ordered by name.
     *
     * @param bool $featuredOnly
     * @return array
     */
    public function getActiveBrands(bool $featuredOnly = false): array
    {
        $builder = $this->where('is_active', 1)->where('deleted_at', null);
        if ($featuredOnly) {
            $builder->where('is_featured', 1);
        }
        return $builder->orderBy('name', 'ASC')->findAll();
    }
}
