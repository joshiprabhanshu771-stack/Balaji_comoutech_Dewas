<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFaqs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'category' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => 'General',
            ],
            'question' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'answer' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'sort_order' => [
                'type' => 'INT',
                'default' => 0,
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
        $this->forge->createTable('faqs');
    }

    public function down()
    {
        $this->forge->dropTable('faqs');
    }
}
