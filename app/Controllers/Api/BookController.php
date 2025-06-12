<?php

namespace App\Controllers\Api;

use App\Controllers\Api\BaseApiController;
use App\Models\BookModel;
use App\Models\AuthorModel;
use App\Models\PublisherModel;

class BookController extends BaseApiController
{
    /**
      @var BookModel
     */
    protected $model;
    protected $modelName = BookModel::class;
    protected $format    = 'json';

    protected $authorModel;
    protected $publisherModel;

    public function __construct()
    {
        $this->authorModel = new AuthorModel();
        $this->publisherModel = new PublisherModel();
    }

    // Get api/books/
    public function index()
    {
        $books = $this->model->select('books.*, authors.name as author_name, publishers.name as publisher_name')
            ->join('authors', 'authors.id = books.author_id')
            ->join('publishers', 'publishers.id = books.publisher_id')
            ->findAll();
        return $this->respondWithSuccess($books, 'Books retrieved successfully');
    }

    // Get api/books/id
    public function show($id = null)
    {
        $book = $this->model->select('books.*, authors.name as author_name, publishers.name as publisher_name')
            ->join('authors', 'authors.id = books.author_id')
            ->join('publishers', 'publishers.id = books.publisher_id')
            ->find($id);
        if (!$book) {
            return $this->respondWithError('Book not found', 404);
        }
        return $this->respondWithSuccess($book, 'Book retrieved successfully');
    }

    // Post api/books/
    public function create()
    {
        $data = $this->request->getPost();

        if (!$this->authorModel->find($data['author_id'])) {
            return $this->respondWithError('Author not found', 404);
        }

        if (!$this->publisherModel->find($data['publisher_id'])) {
            return $this->respondWithError('Publisher not found', 404);
        }

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
