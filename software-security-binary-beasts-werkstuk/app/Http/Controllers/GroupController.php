<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\GroupRequest;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GroupController extends Controller
{
    public function __construct() {
        //error_log("Group Controller");
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
        // Todo: Nieuwe groepsnamen moeten uniek zijn
        // Momenteel redirecten we gewoon terug ook als er foutmeldingen zijn, bv als naam niet uniek is
        $newGroup = new Group([
            "name" => $request->name,
        ]);
        $newGroup->admin_id = Auth::id();
        $newGroup->save();
        return redirect(route("groups.index"));
    }
}