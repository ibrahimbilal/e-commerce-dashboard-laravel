<?php

namespace App\Http\Controllers;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view gallery');
    }

    public function index()
    {
        return view('gallery.index');
    }
}
