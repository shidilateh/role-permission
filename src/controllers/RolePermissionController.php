<?php

namespace Amdxion\RolePermission\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RolePermissionController extends Controller
{
	public function __construct()
	{
		// $this->middleware(['web','auth']);
	}

    public function index()
    {
    	// return "as";
    	return view('role-permission::index');
    }

    public function roles()
    {
    	// return "as";
    	return view('role-permission::role');
    }

    public function permissions()
    {
    	// return "as";
    	return view('role-permission::permission');
    }
}
