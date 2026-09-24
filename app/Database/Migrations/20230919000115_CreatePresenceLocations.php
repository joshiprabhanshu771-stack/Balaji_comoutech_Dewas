<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePresenceLocations extends Migration
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
            'address_line1' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'address_line2' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => 'Dewas',
            ],
            'state' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => 'Madhya Pradesh',
            ],
            'pincode' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'default' => '455001',
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
                'null' => false,
            ],
            'alternate_phone' => [
                'type' => 'VARCHAR',
                'constraint' => '30',
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => false,
            ],
            'landmark' => [
                'type' => 'VARCHAR',
                'constraint' => '200',
                'null' => true,
            ],
            'google_maps_embed' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'google_maps_link' => [
                'type' => 'VARCHAR',
                'constraint' => '500',
                'null' => true,
            ],
            'opening_hours' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'default' => 'Mon - Sat: 10:00 AM - 08:30 PM, Sun: Closed / By Appt',
            ],
            'is_primary' => [
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
        $this->forge->createTable('presence_locations');
    }

    public function down()
    {
        $this->forge->dropTable('presence_locations');
    }
}
