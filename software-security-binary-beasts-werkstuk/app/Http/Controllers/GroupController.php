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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        return view("groups.details", ["group" => $group]);
    }

    public function showUser($id){
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
        error_log(json_encode($request));
        
        $group = Group::findOrFail($request->groupId);
        error_log($group->name);
        $member = User::findOrFail($request->memberId);
        error_log($member->name);
        if($group && $member){
            $group->members()->detach($member);
        }
        return redirect(route("groups.details", ["id" => $group->id]));
    }
    public function addMember(Request $request){
        
        error_log("Add member function");
        error_log($request->groupId);
        error_log($request->memberId);
        error_log(json_encode($request));
        
        $group = Group::findOrFail($request->groupId);
        error_log($group->name);
        $member = User::findOrFail($request->memberId);
        error_log($member->name);
        if($group && $member){
            $group->members()->attach($member);
        }
        return redirect(route("groups.details", ["id" => $group->id]));
    }
}