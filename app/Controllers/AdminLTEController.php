<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AdminLTEController extends Controller
{
    public function index()
    {
        return view('adminlte_view');
    }
}
