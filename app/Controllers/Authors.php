<?php

namespace App\Controllers;

class Authors extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Authors',
            'description' => 'Manage your authors',
        ];
        return view('pages/authors/index', $data);
    }
}
