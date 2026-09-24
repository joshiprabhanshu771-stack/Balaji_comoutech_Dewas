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
        'is_featured',
        'status',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getActiveBrands($featuredOnly = false)
    {
        $builder = $this->where('status', 'active');
        if ($featuredOnly) {
            $builder->where('is_featured', 1);
        }
        return $builder->orderBy('name', 'ASC')->findAll();
    }
}
