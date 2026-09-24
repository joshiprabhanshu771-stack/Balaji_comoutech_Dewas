<?php

namespace App\Models;

use CodeIgniter\Model;

class WishlistModel extends Model
{
    protected $table            = 'wishlists';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getOrCreateWishlist($userId)
    {
        $wishlist = $this->where('user_id', $userId)->first();
        if (!$wishlist) {
            $id = $this->insert(['user_id' => $userId]);
            $wishlist = $this->find($id);
        }
        return $wishlist;
    }
}
