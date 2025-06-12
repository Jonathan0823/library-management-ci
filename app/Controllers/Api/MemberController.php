<?php

namespace App\Controllers\Api;

use App\Controllers\Api\BaseApiController;
use App\Models\MemberModel;

class MemberController extends BaseApiController
{
    /**
     * @var MemberModel
     */
    protected $model;
    protected $modelName = MemberModel::class;
    protected $format    = 'json';

    // Get api/members/
    public function index()
    {
        $members = $this->model->findAll();
        return $this->respondWithSuccess($members, 'Members retrieved successfully');
    }

    // Get api/members/id
    public function show($id = null)
    {
        $member = $this->model->find($id);
        if (!$member) {
            return $this->respondWithError('Member not found', 404);
        }
        return $this->respondWithSuccess($member, 'Member retrieved successfully');
    }

    // Post api/members/
    public function create()
    {
        $data = $this->request->getPost();
        if ($this->model->insert($data)) {
            return $this->respondWithSuccess($data, 'Member created successfully', 201);
        }
        return $this->respondWithError($this->model->errors());
    }

    // Put api/members/id
    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        if ($this->model->update($id, $data)) {
            return $this->respondWithSuccess($data, 'Member updated successfully');
        }
        return $this->respondWithError($this->model->errors());
    }

    // Delete api/members/id
    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondWithSuccess(null, 'Member deleted successfully');
        }
        return $this->respondWithError('Member not found or could not be deleted', 404);
    }
}
