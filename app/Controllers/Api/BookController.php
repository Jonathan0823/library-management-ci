<?php

namespace App\Controllers\Api;

use App\Controllers\Api\BaseApiController;
use App\Models\BookModel;

class BookController extends BaseApiController
{
    protected $modelName = BookModel::class;
    protected $format    = 'json';

    // Get api/books/
    public function index()
    {
        $books = $this->model->findAll();
        return $this->respondWithSuccess($books, 'Books retrieved successfully');
    }

    // Get api/books/id
    public function show($id = null)
    {
        $book = $this->model->find($id);
        if (!$book) {
            return $this->respondWithError('Book not found', 404);
        }
        return $this->respondWithSuccess($book, 'Book retrieved successfully');
    }

    // Post api/books/
    public function create()
    {
        $data = $this->request->getJSON(true);
        if ($this->model->insert($data)) {
            return $this->respondWithSuccess($data, 'Book created successfully', 201);
        }
        return $this->respondWithError($this->model->errors());
    }

    // Put api/books/id
    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        if ($this->model->update($id, $data)) {
            return $this->respondWithSuccess($data, 'Book updated successfully');
        }
        return $this->respondWithError($this->model->errors());
    }

    // Delete api/books/id
    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondWithSuccess(null, 'Book deleted successfully');
        }
        return $this->respondWithError('Book not found or could not be deleted', 404);
    }
}
