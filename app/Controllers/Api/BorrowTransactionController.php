<?php

namespace App\Controllers\Api;

use App\Controllers\Api\BaseApiController;
use App\Models\BorrowTransactionModel;

class BorrowTransactionController extends BaseApiController
{
    protected $modelName = BorrowTransactionModel::class;
    protected $format    = 'json';

    // Get api/borrows/
    public function index()
    {
        $borrows = $this->model->findAll();
        return $this->respondWithSuccess($borrows, 'Borrows retrieved successfully');
    }

    // Get api/borrows/id
    public function show($id = null)
    {
        $borrow = $this->model->find($id);
        if (!$borrow) {
            return $this->respondWithError('Borrow not found', 404);
        }
        return $this->respondWithSuccess($borrow, 'Borrow retrieved successfully');
    }

    // Post api/borrows/
    public function create()
    {
        $data = $this->request->getJSON(true);
        if ($this->model->insert($data)) {
            return $this->respondWithSuccess($data, 'Borrow created successfully', 201);
        }
        return $this->respondWithError($this->model->errors());
    }

    // Put api/borrows/id
    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        if ($this->model->update($id, $data)) {
            return $this->respondWithSuccess($data, 'Borrow updated successfully');
        }
        return $this->respondWithError($this->model->errors());
    }

    // Delete api/borrows/id
    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondWithSuccess(null, 'Borrow deleted successfully');
        }
        return $this->respondWithError('Borrow not found or could not be deleted', 404);
    }
}
