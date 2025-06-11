<?php

namespace App\Models;

use CodeIgniter\Model;

class PublisherModel extends Model
{
    protected $table          = 'publishers';
    protected $primaryKey     = 'id';
    protected $returnType     = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields  = [
        'name',
    ];
    protected $useTimestamps      = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [
          'name' => 'required|string|max_length[255]',
    ];
    protected $validationMessages = [
          'name' => [
              'required'    => 'Author name is required.',
              'string'      => 'Author name must be a string.',
              'max_length'  => 'Author name cannot exceed 255 characters.',
          ],
    ];
    protected $skipValidation     = false;
}
