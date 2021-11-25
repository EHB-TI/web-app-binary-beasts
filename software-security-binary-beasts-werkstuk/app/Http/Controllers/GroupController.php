<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GroupRequest;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GroupController extends Controller
{
    public function __construct() {
        error_log("Group Controller");
        $this->middleware("auth");
        $this->middleware("isTeacher")->except("index", "showGroup");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $membergroups = Auth::user()->groups;
        $admingroups = Group::where("admin_id", Auth::id())->get();
        return view('groups.index', ["membergroups" => $membergroups, "admingroups" => $admingroups]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showGroup($id)
    {
        $group = Group::findOrFail($id);
        if($group->members->contains(Auth::user()) || $group->admin_id == Auth::id()){
            
            return view("groups.details", ["group" => $group]);
        }
        return redirect()->back();
    }
    
    public function newGroup(GroupRequest $request){
        $newGroup = new Group([
            "name" => $request->name,
        ]);
        $newGroup->admin_id = Auth::id();
        $newGroup->save();
        $newGroup->members()->attach(Auth::user());
        return redirect(route("groups.index"));
    }
    public function removeMember(Request $request){
        $group = Group::findOrFail($request->groupId);
        $member = User::findOrFail($request->memberId);
        if($group && $member){
            $group->members()->detach($member);
        }
        return redirect()->back();
    }
    public function addMember(Request $request){        
        $group = Group::findOrFail($request->groupId);
        $member = User::findOrFail($request->memberId);
        if($group && $member){
            $group->members()->attach($member);
        }
        return redirect()->back();
    }
    public function delete(Request $request){
        $group = Group::findOrFail($request->groupId);
        if($group && $group->admin_id === Auth::id()){
            foreach($group->events as $event){
                $event->groups()->detach();
                $event->delete();
            }
            $group->delete();
        }
        return redirect()->back();
    }
    
    public function edit($id){
        $group = Group::findOrFail($id);
        return view("groups.edit", ["group" => $group]);
    }

    public function postEdit($id, GroupRequest $request){
        $group = Group::findOrFail($id);        
        if($group && $group->admin_id === Auth::id()){            
            $group->name = $request->name;
            $group->save();            
        }
        return redirect(route("groups.index"));
    }
}