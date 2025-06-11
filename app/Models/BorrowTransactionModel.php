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

    protected $validationRules    = [
            'book_id'      => 'required|integer',
            'member_id'    => 'required|integer',
            'borrow_date'  => 'required|valid_date',
            'return_date'  => 'permit_empty|valid_date',
            'due_date'     => 'required|valid_date',
            'status'       => 'required|in_list[borrowed,returned,overdue]',
      ];
    protected $validationMessages = [
          'book_id' => [
              'required' => 'Book ID is required.',
              'integer'  => 'Book ID must be an integer.',
          ],
          'member_id' => [
              'required' => 'Member ID is required.',
              'integer'  => 'Member ID must be an integer.',
          ],
          'borrow_date' => [
              'required'   => 'Borrow date is required.',
              'valid_date' => 'Borrow date must be a valid date.',
          ],
          'return_date' => [
              'valid_date' => 'Return date must be a valid date if provided.',
          ],
          'due_date' => [
              'required'   => 'Due date is required.',
              'valid_date' => 'Due date must be a valid date.',
          ],
          'status' => [
              'required'   => 'Status is required.',
              'in_list'    => 'Status must be one of: borrowed, returned, overdue.',
          ],
    ];
    protected $skipValidation     = false;
}
