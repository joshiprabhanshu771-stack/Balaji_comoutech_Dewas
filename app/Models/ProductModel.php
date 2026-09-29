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
        'model_number',
        'sku',
        'short_description',
        'description',
        'full_description',
        'specifications',
        'warranty_info',
        'price',
        'discount_price',
        'stock_status',
        'main_image',
        'is_featured',
        'is_hot_deal',
        'is_active',
        'status',
        'views_count',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    /**
     * Common query builder for filtered product queries.
     *
     * @param array $filters
     * @return \CodeIgniter\Database\BaseBuilder
     */
    protected function buildFilteredQuery(array $filters = [])
    {
        $builder = $this->builder()
                        ->join('categories', 'categories.id = products.category_id', 'left')
                        ->join('brands', 'brands.id = products.brand_id', 'left')
                        ->where('products.is_active', 1)
                        ->where('products.deleted_at', null);

        // Category Filter (by slug or id)
        if (!empty($filters['category_slug'])) {
            $builder->where('categories.slug', trim($filters['category_slug']));
        } elseif (!empty($filters['category_id'])) {
            $builder->where('products.category_id', (int)$filters['category_id']);
        }

        // Brand Filter (by slug or id)
        if (!empty($filters['brand_slug'])) {
            $builder->where('brands.slug', trim($filters['brand_slug']));
        } elseif (!empty($filters['brand_id'])) {
            $builder->where('products.brand_id', (int)$filters['brand_id']);
        }

        // Search Query across name, short_description, description, specifications, model_number, sku, category, brand
        if (!empty($filters['search'])) {
            $searchTerm = trim((string)$filters['search']);
            if ($searchTerm !== '') {
                $builder->groupStart()
                        ->like('products.name', $searchTerm)
                        ->orLike('products.short_description', $searchTerm)
                        ->orLike('products.description', $searchTerm)
                        ->orLike('products.specifications', $searchTerm)
                        ->orLike('products.model_number', $searchTerm)
                        ->orLike('products.sku', $searchTerm)
                        ->orLike('categories.name', $searchTerm)
                        ->orLike('brands.name', $searchTerm)
                        ->groupEnd();
            }
        }

        // Stock Status Filter
        if (!empty($filters['stock_status'])) {
            $builder->where('products.stock_status', trim($filters['stock_status']));
        }

        // Featured & Hot Deals Flags
        if (isset($filters['is_featured']) && $filters['is_featured'] !== '') {
            $builder->where('products.is_featured', (int)$filters['is_featured']);
        }
        if (isset($filters['is_hot_deal']) && $filters['is_hot_deal'] !== '') {
            $builder->where('products.is_hot_deal', (int)$filters['is_hot_deal']);
        }

        return $builder;
    }

    /**
     * Retrieve paginated filtered products with joined category and brand info.
     *
     * @param array $filters
     * @param int|null $limit
     * @param int $offset
     * @return array
     */
    public function getFilteredProducts(array $filters = [], ?int $limit = 12, int $offset = 0): array
    {
        $builder = $this->buildFilteredQuery($filters);
        $builder->select('products.*, categories.name as category_name, categories.slug as category_slug, brands.name as brand_name, brands.slug as brand_slug');

        // Sorting
        $sort = $filters['sort'] ?? 'latest';
        switch ($sort) {
            case 'price_low':
                $builder->orderBy('COALESCE(NULLIF(products.discount_price, 0), products.price, 999999999)', 'ASC');
                break;
            case 'price_high':
                $builder->orderBy('COALESCE(NULLIF(products.discount_price, 0), products.price, 0)', 'DESC');
                break;
            case 'popular':
                $builder->orderBy('products.views_count', 'DESC')->orderBy('products.id', 'DESC');
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

        return $builder->get()->getResultArray();
    }

    /**
     * Count total matching products for pagination.
     *
     * @param array $filters
     * @return int
     */
    public function countFilteredProducts(array $filters = []): int
    {
        $builder = $this->buildFilteredQuery($filters);
        return (int)$builder->countAllResults();
    }

    /**
     * Find a single active product by slug.
     *
     * @param string $slug
     * @return array|null
     */
    public function getProductBySlug(string $slug): ?array
    {
        return $this->select('products.*, categories.name as category_name, categories.slug as category_slug, brands.name as brand_name, brands.slug as brand_slug')
                    ->join('categories', 'categories.id = products.category_id', 'left')
                    ->join('brands', 'brands.id = products.brand_id', 'left')
                    ->where('products.slug', $slug)
                    ->where('products.is_active', 1)
                    ->where('products.deleted_at', null)
                    ->first();
    }
}
