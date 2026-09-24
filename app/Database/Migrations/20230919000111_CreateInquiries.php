<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInquiries extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'inquiry_no' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => false,
                'unique' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'product_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'service_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => false,
            ],
            'mobile' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false,
            ],
            'subject' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
            ],
            'message' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'inquiry_type' => [
                'type' => 'ENUM',
                'constraint' => ['general', 'product', 'service', 'bulk', 'repair'],
                'default' => 'general',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'in_progress', 'replied', 'closed'],
                'default' => 'pending',
            ],
            'admin_notes' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addForeignKey('user_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('service_id', 'services', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('inquiries');
    }

    public function down()
    {
        $this->forge->dropTable('inquiries');
    }
}
