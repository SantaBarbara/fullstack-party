<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            return redirect()->route('issues');
        }

        return view('index.index');
    }
}
