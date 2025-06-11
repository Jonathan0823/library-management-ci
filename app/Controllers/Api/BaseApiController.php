<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class BaseApiController extends ResourceController
{
    protected function respondWithSuccess($data, string $message = 'Success', int $code = 200)
    {
        return $this->respond([
            'status'  => true,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    protected function respondWithError($message = 'Something went wrong', int $code = 400)
    {
        return $this->respond([
            'status'  => false,
            'message' => $message,
        ], $code);
    }
}
