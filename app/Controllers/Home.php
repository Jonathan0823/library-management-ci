<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Home',
            'description' => 'Manage your books, authors, publishers, and members efficiently.',
        ];
        return view('welcome_message', $data);
    }

    public function about(): void
    {
        echo "This is the about page.";
    }
}
