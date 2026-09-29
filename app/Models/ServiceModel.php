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
        'description',
        'full_description',
        'features',
        'turnaround_time',
        'starting_price',
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
     * Retrieve active services.
     *
     * @param bool $featuredOnly
     * @return array
     */
    public function getActiveServices(bool $featuredOnly = false): array
    {
        $builder = $this->where('is_active', 1)->where('deleted_at', null);
        if ($featuredOnly) {
            $builder->where('is_featured', 1);
        }
        return $builder->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC')->findAll();
    }
}
