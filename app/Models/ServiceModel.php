<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceModel extends Model
{
    protected $table            = 'services';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'slug',
        'icon',
        'image',
        'short_description',
        'full_description',
        'features',
        'turnaround_time',
        'starting_price',
        'is_featured',
        'status',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getActiveServices($featuredOnly = false)
    {
        $builder = $this->where('status', 'active');
        if ($featuredOnly) {
            $builder->where('is_featured', 1);
        }
        return $builder->orderBy('id', 'ASC')->findAll();
    }
}
