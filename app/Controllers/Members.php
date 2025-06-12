<?php

namespace App\Controllers;

class Members extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Members',
            'description' => 'Manage your members',
        ];
        return view('pages/members/index', $data);
    }
}
