<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserNotificationTokens extends Migration
{
    public function up()
    {
        if (!$this->db->tableExists('user_notification_tokens')) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'BIGINT',
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'user_id' => [
                    'type'     => 'INT',
                    'unsigned' => true,
                    'null'     => false,
                ],
                'token' => [
                    'type' => 'TEXT',
                    'null' => false,
                ],
                'device_type' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '50',
                    'null'       => true,
                ],
                'browser' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                    'null'       => true,
                ],
                'platform' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                    'null'       => true,
                ],
                'is_active' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'default'    => 1,
                    'null'       => false,
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
            $this->forge->addKey('user_id');
            $this->forge->addKey('is_active');
            $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
            $this->forge->createTable('user_notification_tokens', true);
        }
    }

    public function down()
    {
        $this->forge->dropTable('user_notification_tokens', true);
    }
}
