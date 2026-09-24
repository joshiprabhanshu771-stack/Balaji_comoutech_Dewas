<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProducts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'category_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'brand_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'name' => [
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
            'sku' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'short_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'full_description' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'specifications' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'discount_price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'stock_status' => [
                'type' => 'ENUM',
                'constraint' => ['in_stock', 'out_of_stock', 'on_demand'],
                'default' => 'in_stock',
            ],
            'main_image' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'is_featured' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'is_hot_deal' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default' => 'active',
            ],
            'views_count' => [
                'type' => 'INT',
                'default' => 0,
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
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('brand_id', 'brands', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
