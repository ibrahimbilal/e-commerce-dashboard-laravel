<?php

namespace App\Http\Controllers;

class LanguageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view languages');
    }

    public function index()
    {
        return view('languages.index');
    }
}
