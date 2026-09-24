<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOffers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => false,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => '220',
                'null' => false,
                'unique' => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'banner_image' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'discount_text' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'coupon_code' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'valid_from' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'valid_until' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('offers');
    }

    public function down()
    {
        $this->forge->dropTable('offers');
    }
}
