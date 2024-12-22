<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('customer.home'); // Make sure this view exists
    }

    public function index2()
    {
        return view('admin.index2'); // Make sure this view exists
    }

    public function index3()
    {
        return view('owner.index3'); // Make sure this view exists
    }
}