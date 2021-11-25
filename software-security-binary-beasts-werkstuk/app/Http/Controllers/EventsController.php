<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Only show public events on the events page
        $events = Event::doesntHave("groups")->orderBy("eventdate", "asc")->get();
        return view('events.index', ["events" => $events]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Auth::user()->groups()->get();
        return view('events.create',compact('groups'));
    }


    public function createEvent(Request $request)
    {
        //dd($request->all());
        $event = new Event;
        $event->eventname = $request->eventName;
        $event->eventdescription = $request->eventDescription;
        $event->eventdate=$request->eventDate;
        $event->eventTime=$request->eventTime;
        $event->host_id=Auth::user()->id;
        $event->save();
        $event->groups()->attach($request->eventGroup);
        $events = Event::orderBy("eventdate", "asc")->get();
        return view('events.index', ["events" => $events]);

    }

    public function acceptEvent(Request $request)
    {
        echo($request->event_id);
        $event = Event::findOrFail($request->event_id);
        $event->attendees()->attach(Auth::user());
        return redirect()->back();
    }
    public function rejectEvent(Request $request){
        $event = Event::findOrFail($request->event_id);
        $event->attendees()->detach(Auth::user());
        return redirect()->back();
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
    public function show($id)
    {
        $event = Event::with("attendees", "groups.members")->where("id", $id)->first();
        $isGroupEvent = $event->groups()->count() > 0;
        
        // We only show the list of other attendees if the user is a teacher 
        // or if the event belongs to a group where the user is a member
        if(Auth::user()->roles()->where("role_name", "TEACHER")->count() > 0){
            error_log("User is a teacher");
            // User is a teacher so we can give all the info
            return view("events.details", ["event" => $event, "canSeeAttendees" => true]);
        }
        else{
            // User is not a teacher
            error_log("User is not a teacher");
            foreach($event->groups as $group){
                error_log($group->name);
                if($group->members->contains(Auth::user())){
                    error_log("User is a group member!");
                    return view("events.details", ["event" => $event, "canSeeAttendees" => true]);
                }
            }
            // User isn't a Teacher and isn't a member of a group attached to the event
            if(!$isGroupEvent){
                // If the event is public, everybody can see the details
                // but only teachers can see attendees
                error_log("The event is public");
                $eventWithoutAttendees = Event::without("attendees")->where("id", $id)->first();
                
                return view("events.details", ["event" => $eventWithoutAttendees, "canSeeAttendees" => false]);
                
            }
            else{
                // The event is not public and the user is not associated with it, he can't get any info
                error_log("Is group event and user has no access");
                return redirect(route("dashboard"));    
            }
        }
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
}