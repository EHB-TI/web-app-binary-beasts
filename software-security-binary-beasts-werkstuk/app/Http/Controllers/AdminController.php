<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;

class AdminController extends Controller
{
    public function __construct() {
        error_log("Admin Controller");
        $this->middleware("auth");
        $this->middleware("isAdmin");
    }
    public function index(){
        $users = User::with("roles")->orderBy("name", "asc")->get();
        return view("admin.index", ["users" => $users]);
    }
    public function addAdmin(Request $request){
        $role = Role::find(1);
        $user = User::findOrFail($request->memberId);
        $role->users()->attach($user);
        return redirect()->back();
    }
    public function removeAdmin(Request $request){
        // Prevent ourselves from removing the admin role from the default admin account
        if($request->memberId != 1){
            $role = Role::find(1);
            $user = User::findOrFail($request->memberId);
            $role->users()->detach($user);
        }
        return redirect()->back();
    }
    public function addTeacher(Request $request){
        $role = Role::find(3);
        $user = User::findOrFail($request->memberId);
        $role->users()->attach($user);
        return redirect()->back();
    }
    public function removeTeacher(Request $request){
        $role = Role::find(3);
        $user = User::findOrFail($request->memberId);
        $role->users()->detach($user);
        return redirect()->back();
    }
    public function addStudent(Request $request){
        $role = Role::find(2);
        $user = User::findOrFail($request->memberId);
        $role->users()->attach($user);
        return redirect()->back();
    }   
    public function removeStudent(Request $request){
        $role = Role::find(2);
        $user = User::findOrFail($request->memberId);
        $role->users()->detach($user);
        return redirect()->back();
    } 
}