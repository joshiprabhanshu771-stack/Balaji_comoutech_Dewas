<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'sku',
        'short_description',
        'full_description',
        'specifications',
        'price',
        'discount_price',
        'stock_status',
        'main_image',
        'is_featured',
        'is_hot_deal',
        'status',
        'views_count',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function getFilteredProducts($filters = [], $limit = 12, $offset = 0)
    {
        $builder = $this->select('products.*, categories.name as category_name, categories.slug as category_slug, brands.name as brand_name, brands.slug as brand_slug')
                        ->join('categories', 'categories.id = products.category_id', 'left')
                        ->join('brands', 'brands.id = products.brand_id', 'left')
                        ->where('products.status', 'active');

        if (!empty($filters['category_id'])) {
            $builder->where('products.category_id', $filters['category_id']);
        }
        if (!empty($filters['category_slug'])) {
            $builder->where('categories.slug', $filters['category_slug']);
        }
        if (!empty($filters['brand_id'])) {
            $builder->where('products.brand_id', $filters['brand_id']);
        }
        if (!empty($filters['brand_slug'])) {
            $builder->where('brands.slug', $filters['brand_slug']);
        }
        if (!empty($filters['search'])) {
            $builder->groupStart()
                    ->like('products.name', $filters['search'])
                    ->orLike('products.short_description', $filters['search'])
                    ->orLike('products.specifications', $filters['search'])
                    ->orLike('categories.name', $filters['search'])
                    ->orLike('brands.name', $filters['search'])
                    ->groupEnd();
        }
        if (!empty($filters['stock_status'])) {
            $builder->where('products.stock_status', $filters['stock_status']);
        }
        if (isset($filters['is_featured']) && $filters['is_featured'] !== '') {
            $builder->where('products.is_featured', $filters['is_featured']);
        }
        if (isset($filters['is_hot_deal']) && $filters['is_hot_deal'] !== '') {
            $builder->where('products.is_hot_deal', $filters['is_hot_deal']);
        }

        // Sorting
        $sort = $filters['sort'] ?? 'latest';
        switch ($sort) {
            case 'price_low':
                $builder->orderBy('COALESCE(products.discount_price, products.price)', 'ASC');
                break;
            case 'price_high':
                $builder->orderBy('COALESCE(products.discount_price, products.price)', 'DESC');
                break;
            case 'popular':
                $builder->orderBy('products.views_count', 'DESC');
                break;
            case 'name_asc':
                $builder->orderBy('products.name', 'ASC');
                break;
            case 'latest':
            default:
                $builder->orderBy('products.id', 'DESC');
                break;
        }

        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        return $builder->findAll();
    }

    public function countFilteredProducts($filters = [])
    {
        $builder = $this->join('categories', 'categories.id = products.category_id', 'left')
                        ->join('brands', 'brands.id = products.brand_id', 'left')
                        ->where('products.status', 'active');

        if (!empty($filters['category_id'])) {
            $builder->where('products.category_id', $filters['category_id']);
        }
        if (!empty($filters['category_slug'])) {
            $builder->where('categories.slug', $filters['category_slug']);
        }
        if (!empty($filters['brand_id'])) {
            $builder->where('products.brand_id', $filters['brand_id']);
        }
        if (!empty($filters['brand_slug'])) {
            $builder->where('brands.slug', $filters['brand_slug']);
        }
        if (!empty($filters['search'])) {
            $builder->groupStart()
                    ->like('products.name', $filters['search'])
                    ->orLike('products.short_description', $filters['search'])
                    ->orLike('products.specifications', $filters['search'])
                    ->orLike('categories.name', $filters['search'])
                    ->orLike('brands.name', $filters['search'])
                    ->groupEnd();
        }
        if (!empty($filters['stock_status'])) {
            $builder->where('products.stock_status', $filters['stock_status']);
        }
        if (isset($filters['is_featured']) && $filters['is_featured'] !== '') {
            $builder->where('products.is_featured', $filters['is_featured']);
        }
        if (isset($filters['is_hot_deal']) && $filters['is_hot_deal'] !== '') {
            $builder->where('products.is_hot_deal', $filters['is_hot_deal']);
        }

        return $builder->countAllResults();
    }

    public function getProductBySlug($slug)
    {
        return $this->select('products.*, categories.name as category_name, categories.slug as category_slug, brands.name as brand_name, brands.slug as brand_slug')
                    ->join('categories', 'categories.id = products.category_id', 'left')
                    ->join('brands', 'brands.id = products.brand_id', 'left')
                    ->where('products.slug', $slug)
                    ->where('products.status', 'active')
                    ->first();
    }
}
