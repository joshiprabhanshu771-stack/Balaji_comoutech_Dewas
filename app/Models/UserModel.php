<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'role_id',
        'name',
        'email',
        'mobile',
        'password_hash',
        'status',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'name'          => 'required|min_length[3]|max_length[100]',
        'email'         => 'required|valid_email|is_unique[users.email,id,{id}]',
        'mobile'        => 'required|min_length[10]|max_length[15]',
        'password_hash' => 'required',
    ];

    public function getUserWithRole($userId)
    {
        return $this->select('users.*, roles.name as role_name')
                    ->join('roles', 'roles.id = users.role_id', 'left')
                    ->where('users.id', $userId)
                    ->first();
    }

    public function getUserWithRoleByEmail($email)
    {
        return $this->select('users.*, roles.name as role_name')
                    ->join('roles', 'roles.id = users.role_id', 'left')
                    ->where('users.email', $email)
                    ->first();
    }
}
