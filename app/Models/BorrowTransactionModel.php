<?php

namespace App\Models;

use CodeIgniter\Model;

class BorrowTransactionModel extends Model
{
    protected $table          = 'borrow_transactions';
    protected $primaryKey     = 'id';
    protected $returnType     = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields  = [
          'book_id',
          'member_id',
          'borrow_date',
          'return_date',
          'due_date',
          'status',
    ];
    protected $useTimestamps      = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
