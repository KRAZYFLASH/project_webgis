<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('dashboard/fileutama');
    }
    public function index2()
    {
        return view('default');
    }
}