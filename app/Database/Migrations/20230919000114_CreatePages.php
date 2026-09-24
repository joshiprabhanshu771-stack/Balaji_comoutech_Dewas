<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePages extends Migration
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
                'constraint' => '150',
                'null' => false,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => '170',
                'null' => false,
                'unique' => true,
            ],
            'content' => [
                'type' => 'LONGTEXT',
                'null' => false,
            ],
            'meta_title' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'meta_description' => [
                'type' => 'TEXT',
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
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pages');
    }

    public function down()
    {
        $this->forge->dropTable('pages');
    }
}
