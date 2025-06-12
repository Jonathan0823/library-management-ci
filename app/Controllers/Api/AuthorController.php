<?php

namespace App\Controllers\Api;

use App\Controllers\Api\BaseApiController;
use App\Models\AuthorModel;

class AuthorController extends BaseApiController
{
    /**
     * @var AuthorModel
     */
    protected $model;
    protected $modelName = AuthorModel::class;
    protected $format    = 'json';

    // Get api/authors/
    public function index()
    {
        $authors = $this->model->findAll();
        return $this->respondWithSuccess($authors, 'Authors retrieved successfully');
    }

    // Get api/authors/id
    public function show($id = null)
    {
        $author = $this->model->find($id);
        if (!$author) {
            return $this->respondWithError('Author not found', 404);
        }
        return $this->respondWithSuccess($author, 'Author retrieved successfully');
    }

    // Post api/authors/
    public function create()
    {
        $data = $this->request->getJSON(true);
        if ($this->model->insert($data)) {
            return $this->respondWithSuccess($data, 'Author created successfully', 201);
        }
        return $this->respondWithError($this->model->errors());
    }

    // Put api/authors/id
    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        if ($this->model->update($id, $data)) {
            return $this->respondWithSuccess($data, 'Author updated successfully');
        }
        return $this->respondWithError($this->model->errors());
    }

    // Delete api/authors/id
    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondWithSuccess(null, 'Author deleted successfully');
        }
        return $this->respondWithError('Author not found or could not be deleted', 404);
    }
}
