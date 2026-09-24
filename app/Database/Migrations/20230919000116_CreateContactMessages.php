<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContactMessages extends Migration
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
                'null' => false,
            ],
            'message' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'is_read' => [
                'type' => 'TINYINT',
                'constraint' => 1,
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
        $this->forge->createTable('contact_messages');
    }

    public function down()
    {
        $this->forge->dropTable('contact_messages');
    }
}
