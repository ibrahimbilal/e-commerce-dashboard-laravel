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

	// profile page
	public function profile()
	{
		$user = Auth::user();
		$roles = Role::all();
		return view('admin.profile', compact('user', 'roles'));
	}
}
