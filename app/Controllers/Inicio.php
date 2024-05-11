<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Intro extends Controller
{
    public function index()
    {
        return view('inicio');
    }
}