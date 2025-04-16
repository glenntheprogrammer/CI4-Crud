<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index()
    {
        return view('login'); // your login view filename
    }

    public function auth()
    {
        // For now, just redirect to AdminLTE view directly (no auth check yet)
        return redirect()->to('/dashboard');
    }

    public function dashboard()
    {
        return view('adminlte_view'); // make sure this file exists in app/Views
    }
}
