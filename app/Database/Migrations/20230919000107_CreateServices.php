<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateServices extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => false,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => '170',
                'null' => false,
                'unique' => true,
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
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
            'features' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'turnaround_time' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'starting_price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
            ],
            'is_featured' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default' => 'active',
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
        $this->forge->createTable('services');
    }

    public function down()
    {
        $this->forge->dropTable('services');
    }
}
