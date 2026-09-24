<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWishlistItems extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'wishlist_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'product_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
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
        $this->forge->addForeignKey('wishlist_id', 'wishlists', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('wishlist_items');
    }

    public function down()
    {
        $this->forge->dropTable('wishlist_items');
    }
}
