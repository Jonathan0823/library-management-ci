<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table          = 'books';
    protected $primaryKey     = 'id';
    protected $returnType     = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields  = [
        'title',
        'author_id',
        'publisher_id',
        'publication_year',
        'quantity',
        'available_quantity',
    ];
    protected $useTimestamps      = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'title'              => 'required|string|max_length[255]',
        'author_id'          => 'required|integer|is_natural_no_zero',
        'publisher_id'       => 'required|integer|is_natural_no_zero',
        'publication_year'   => 'required|integer|exact_length[4]|greater_than[1000]',
        'quantity'           => 'required|integer|min_length[1]|greater_than_equal_to[0]',
        'available_quantity' => 'required|integer|less_than_equal_to[quantity]|greater_than_equal_to[0]',
    ];
    protected $validationMessages = [
        'title' => [
            'required'    => 'Book title is required.',
            'string'      => 'Book title must be a string.',
            'max_length'  => 'Book title cannot exceed 255 characters.',
        ],
        'author_id' => [
            'required'            => 'Author ID is required.',
            'integer'             => 'Author ID must be an integer.',
            'is_natural_no_zero'  => 'Author ID is not valid.',
        ],
        'publisher_id' => [
            'required'            => 'Publisher ID is required.',
            'integer'             => 'Publisher ID must be an integer.',
            'is_natural_no_zero'  => 'Publisher ID is not valid.',
        ],
        'publication_year' => [
            'required'       => 'Publication year is required.',
            'integer'        => 'Publication year must be an integer.',
            'exact_length'   => 'Publication year must be exactly 4 digits.',
            'greater_than'   => 'Publication year must be greater than 1000.',
        ],
        'quantity' => [
            'required'               => 'Book quantity is required.',
            'integer'                => 'Book quantity must be an integer.',
            'min_length'             => 'Book quantity must be at least 1.',
            'greater_than_equal_to'  => 'Book quantity cannot be negative.',
        ],
        'available_quantity' => [
            'required'               => 'Available quantity is required.',
            'integer'                => 'Available quantity must be an integer.',
            'greater_than_equal_to' => 'Available quantity cannot be negative.',
            'less_than_equal_to'    => 'Available quantity cannot exceed total quantity.',
        ],
    ];
    protected $skipValidation     = false;
}
