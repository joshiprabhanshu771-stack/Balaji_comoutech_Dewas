<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInquiryReplies extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'inquiry_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'user_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'message' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'sent_email' => [
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
        $this->forge->addForeignKey('inquiry_id', 'inquiries', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('inquiry_replies');
    }

    public function down()
    {
        $this->forge->dropTable('inquiry_replies');
    }
}
