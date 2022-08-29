<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

	// Admin Panel Index
	public function index()
	{
		return view('admin.index');
	}
}
