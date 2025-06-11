<?php

namespace App\Models;

use CodeIgniter\Model;

class MemberModel extends Model
{
    protected $table          = 'members';
    protected $primaryKey     = 'id';
    protected $returnType     = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields  = [
        'name',
        'address',
        'phone',
        'email',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [
          'name'    => 'required|min_length[3]|max_length[100]',
          'address' => 'permit_empty|max_length[255]',
          'phone'   => 'permit_empty|regex_match[/^\+?[0-9\s\-()]+$/]',
          'email'   => 'permit_empty|valid_email',
    ];
    protected $validationMessages = [
          'name' => [
              'required'    => 'Name is required.',
              'min_length'  => 'Name must be at least 3 characters long.',
              'max_length'  => 'Name cannot exceed 100 characters.',
          ],
          'address' => [
              'max_length'  => 'Address cannot exceed 255 characters.',
          ],
          'phone' => [
              'regex_match' => 'Phone number format is invalid.',
          ],
          'email' => [
              'valid_email' => 'Email address is not valid.',
          ],
    ];
    protected $skipValidation     = false;
}
