<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Search extends Controller
{
    public function index()
    {

        $searchTerm = $this->request->getGet('searchTerm');
        return redirect()->to(site_url("marvel?searchTerm=$searchTerm"));
    }
}