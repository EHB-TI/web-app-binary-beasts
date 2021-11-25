<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Schema;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\UpdateEventRequest;

class EventsController extends Controller
{

    public function __construct() {
        error_log("Event Controller");
        $this->middleware("auth");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        error_log("show event index");
        // Only show public events on the events page
        $userid=Auth::user()->id;
        $events = Event::doesntHave("groups")->orderBy("eventdate", "asc")->get();

        $privateEventsIds = Event::join('event_group','events.id','=','event_group.event_id')
            ->join('groups','event_group.group_id','=','groups.id')
            ->join('group_user','groups.id','=','group_user.group_id')
            ->where('group_user.user_id',$userid)
            ->select('events.id')->get();

        $privateEvents =Event::whereIn('id', $privateEventsIds)->orderBy("eventdate", "asc")->get();

        return view('events.index',compact('events','privateEvents'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        error_log("create event view");
        $groups = Auth::user()->groups()->get();
        return view('events.create',compact('groups'));
    }
    


    public function createEvent(CreateEventRequest $request)
    {
        error_log("create event");
        $event = new Event;
        $event->eventname = $request->eventName;
        $event->eventdescription = $request->eventDescription;
        $event->eventdate=$request->eventDate;
        $event->eventTime=$request->eventTime;
        $event->host_id=Auth::user()->id;
        $event->save();
        $event->groups()->attach($request->eventGroup);

        $userid=Auth::user()->id;
        // public events
        $events = Event::doesntHave("groups")->orderBy("eventdate", "asc")->get();

        $privateEventsIds = Event::join('event_group','events.id','=','event_group.event_id')
            ->join('groups','event_group.group_id','=','groups.id')
            ->join('group_user','groups.id','=','group_user.group_id')
            ->where('group_user.user_id',$userid)
            ->select('events.id')->get();


        $privateEvents =Event::whereIn('id', $privateEventsIds)->orderBy("eventdate", "asc")->get();


        return view('events.index',compact('events','privateEvents'));

    }
    

    public function acceptEvent(Request $request)
    {
        error_log("accept event");
        $event = Event::findOrFail($request->event_id);
        $event->attendees()->attach(Auth::user());
        return redirect()->back();
    }
    public function rejectEvent(Request $request){
        error_log("reject event");
        $event = Event::findOrFail($request->event_id);
        $event->attendees()->detach(Auth::user());
        return redirect()->back();
    }

    public function deleteEvent(Request $request){
        error_log("delete event");
        echo($request->event_id);
        if(Auth::user()->id == $request->host_id) {
            Event::findorfail($request->event_id)->delete();
        }
        return redirect()->route('events.index');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        error_log("Store request");
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        error_log("Show event");
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
    //     error_log("edit event view");
    //     $event = Event::findOrFail($id);
    //     $groups = Auth::user()->groups()->get();
    //     return view('events.edit',compact('event', 'groups'));
    // 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

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