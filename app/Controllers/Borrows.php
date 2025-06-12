<?php

namespace App\Controllers;

class Borrows extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Borrows',
            'description' => 'Manage your borrow transactions',
        ];
        return view('pages/borrows/index', $data);
    }
}
