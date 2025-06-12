<?php

namespace App\Controllers;

class Publishers extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Publishers',
            'description' => 'Manage your  publishers',
        ];
        return view('pages/publishers/index', $data);
    }
}
