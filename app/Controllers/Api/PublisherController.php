<?php

namespace App\Controllers\Api;

use App\Controllers\Api\BaseApiController;
use App\Models\PublisherModel;

class PublisherController extends BaseApiController
{
    /**
     * @var PublisherModel
     */
    protected $model;
    protected $modelName = PublisherModel::class;
    protected $format    = 'json';

    // Get api/publishers/
    public function index()
    {
        $publisher = $this->model->findAll();
        return $this->respondWithSuccess($publisher, 'Publishers retrieved successfully');
    }

    // Get api/publishers/id
    public function show($id = null)
    {
        $publisher = $this->model->find($id);
        if (!$publisher) {
            return $this->respondWithError('Publisher not found', 404);
        }
        return $this->respondWithSuccess($publisher, 'Publisher retrieved successfully');
    }

    // Post api/publishers/
    public function create()
    {
        $data = $this->request->getJSON(true);
        if ($this->model->insert($data)) {
            return $this->respondWithSuccess($data, 'Publisher created successfully', 201);
        }
        return $this->respondWithError($this->model->errors());
    }

    // Put api/publishers/id
    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        if ($this->model->update($id, $data)) {
            return $this->respondWithSuccess($data, 'Publisher updated successfully');
        }
        return $this->respondWithError($this->model->errors());
    }

    // Delete api/publishers/id
    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondWithSuccess(null, 'Publisher deleted successfully');
        }
        return $this->respondWithError('publisher not found or could not be deleted', 404);
    }
}
