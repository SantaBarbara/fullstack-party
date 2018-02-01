<?php

namespace App\Http\Controllers;

class IssuesController extends Controller
{
    public function index()
    {
        return view('issues.index');
    }
}
