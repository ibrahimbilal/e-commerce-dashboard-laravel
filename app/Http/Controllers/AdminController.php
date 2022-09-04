<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{

	// Admin Panel Index
	public function index()
	{
		return view('admin.index');
	}

}
