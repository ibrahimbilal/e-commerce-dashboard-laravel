<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{

	// Admin Panel Index
	public function index()
	{
		return view('admin.index');
	}

}
