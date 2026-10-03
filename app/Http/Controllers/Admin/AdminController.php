<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
	public function __construct()
	{
		$this->middleware('permission:view dashboard');
	}

	// Admin Panel Index
	public function index()
	{
		return redirect()->route('admin.dashboard');
	}

}
