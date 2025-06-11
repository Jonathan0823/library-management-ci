<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBooksTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
              'id'               => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
              'title'            => ['type' => 'VARCHAR', 'constraint' => 255],
              'author_id'        => ['type' => 'INT', 'unsigned' => true],
              'publisher_id'     => ['type' => 'INT', 'unsigned' => true],
              'publication_year' => ['type' => 'INT', 'constraint' => 4],
              'quantity'         => ['type' => 'INT', 'default' => 0],
              'available_quantity' => ['type' => 'INT', 'default' => 0],
              'created_at'       => ['type' => 'DATETIME', 'null' => true],
              'updated_at'       => ['type' => 'DATETIME', 'null' => true],
          ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('author_id', 'authors', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('publisher_id', 'publishers', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('books', true);
    }

    public function down()
    {
        $this->forge->dropTable('books', true);
    }
}
