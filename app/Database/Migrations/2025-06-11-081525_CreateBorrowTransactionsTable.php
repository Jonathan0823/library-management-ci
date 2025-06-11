<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBorrowTransactionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
                   'id'          => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
                   'book_id'     => ['type' => 'INT', 'unsigned' => true],
                   'member_id'   => ['type' => 'INT', 'unsigned' => true],
                   'borrow_date' => ['type' => 'DATE'],
                   'return_date' => ['type' => 'DATE', 'null' => true],
                   'due_date'    => ['type' => 'DATE'],
                   'status'      => ['type' => 'ENUM', 'constraint' => ['borrowed', 'returned', 'overdue']],
                   'created_at'  => ['type' => 'DATETIME', 'null' => true],
                   'updated_at'  => ['type' => 'DATETIME', 'null' => true],
               ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('book_id', 'books', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('member_id', 'members', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('borrow_transactions');
    }

    public function down()
    {
        $this->forge->dropTable('borrow_transactions', true);
    }
}
