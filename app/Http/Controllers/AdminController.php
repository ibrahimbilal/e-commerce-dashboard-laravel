<?php

namespace App\Http\Controllers;

use App\Models\DynamicModel;
use App\Http\Requests\BulkActionRequest;

class AdminController extends Controller
{

	// Admin Panel Index
	public function index()
	{
		return view('admin.index');
	}

}
