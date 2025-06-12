<?php

namespace App\Controllers;

class Books extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Books',
            'description' => 'Manage your books',
        ];
        return view('pages/books/index', $data);
    }
}
