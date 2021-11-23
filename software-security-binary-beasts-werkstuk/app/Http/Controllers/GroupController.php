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
        $this->middleware("isTeacher")->except("index");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // We only show groups where the user is the admin 

        // Todo: also show groups where the user is not just an admin and merge the two or return multiple items

        $membergroups = Auth::user()->groups;
        //error_log(Auth::id());
        //error_log(json_encode($groups));
        $admingroups = Group::where("admin_id", Auth::id())->get();
        return view('groups.index', ["membergroups" => $membergroups, "admingroups" => $admingroups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showGroup($id)
    {
        $group = Group::findOrFail($id);
        return view("groups.details", ["group" => $group]);
    }

    public function showUser($id){
        
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
        error_log("Remove member function");
        error_log($request->groupId);
        error_log($request->memberId);
        
        $group = Group::findOrFail($request->groupId);
        error_log($group->name);
        $member = User::findOrFail($request->memberId);
        error_log($member->name);
        if($group && $member){
            $group->members()->detach($member);
        }
        return redirect()->back();
    }
    public function addMember(Request $request){
        
        error_log("Add member function");
        error_log($request->groupId);
        error_log($request->memberId);
        
        $group = Group::findOrFail($request->groupId);
        error_log($group->name);
        $member = User::findOrFail($request->memberId);
        error_log($member->name);
        if($group && $member){
            $group->members()->attach($member);
        }
        return redirect()->back();
    }
    public function delete(Request $request){
        error_log("delete group");
        $group = Group::findOrFail($request->groupId);
        error_log(Auth::user());
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
        error_log("edit group");
        error_log($id);
        error_log(Auth::user());
        error_log($request->name);
        $group = Group::findOrFail($id);
        error_log($group);
        error_log(Auth::user());
        if($group && $group->admin_id === Auth::id()){
            error_log("Editing group name");
            $group->name = $request->name;
            $group->save();
            
        }
        return redirect(route("groups.index"));
    }
}