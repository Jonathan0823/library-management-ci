<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMembersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
                  'id'         => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
                  'name'       => ['type' => 'VARCHAR', 'constraint' => 255],
                  'address'    => ['type' => 'TEXT'],
                  'phone'      => ['type' => 'VARCHAR', 'constraint' => 20],
                  'email'      => ['type' => 'VARCHAR', 'constraint' => 100, 'unique' => true],
                  'created_at' => ['type' => 'DATETIME', 'null' => true],
                  'updated_at' => ['type' => 'DATETIME', 'null' => true],
              ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('members');
    }

    public function down()
    {
        $this->forge->dropTable('members', true);
    }
}
