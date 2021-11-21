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
        // Todo: Stuur voorlopig alle events mee
        $events = Event::orderBy("eventdate", "asc")->get();
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
        //
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
