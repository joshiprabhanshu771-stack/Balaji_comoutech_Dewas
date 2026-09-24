<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductImages extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'product_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'sort_order' => [
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
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('product_images');
    }

    public function down()
    {
        $this->forge->dropTable('product_images');
    }
}
