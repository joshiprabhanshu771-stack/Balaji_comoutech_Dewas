<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'            => 1,
                'role_id'       => 1, // admin
                'name'          => 'Gourav Joshi (Admin)',
                'email'         => 'admin@example.com',
                'mobile'        => '+91 98260 00000',
                'password_hash' => password_hash('admin123', PASSWORD_BCRYPT),
                'status'        => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'id'            => 2,
                'role_id'       => 2, // customer
                'name'          => 'Rahul Sharma',
                'email'         => 'customer@example.com',
                'mobile'        => '+91 98765 43210',
                'password_hash' => password_hash('customer123', PASSWORD_BCRYPT),
                'status'        => 'active',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];

        foreach ($users as $user) {
            $existing = $this->db->table('users')->where('email', $user['email'])->get()->getFirstRow();
            if (!$existing) {
                $this->db->table('users')->insert($user);
            }
        }
    }
}
