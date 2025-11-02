<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class ListControlller extends Controller
{
    
    public function home()
    {
        $roles = Role::all();
        $permission=Permission::all();
        return view('Settings.grouppermissions', compact('roles','permission'));
    }
}
