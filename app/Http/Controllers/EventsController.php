<?php

namespace App\Http\Controllers;
use App\Http\Requests\EventRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $events = Event::all();
        return Inertia::render('Welcome', [
            'events' => $events,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    public function getEvent(Request $request) {
        $user_id = Auth::user()->id;
        $now = now();
        $events = Event::where('user_id', $user_id)->where('start', '>=', $now)->paginate(10);
        return Inertia::render('Dashboard', [
            'events' => $events
        ]);
    }

    public function myEvents (Request $request) {
        $user_id = Auth::user()->id;
        $myEvents = Event::where('user_id', $user_id)->paginate(10);
        return response()->json($myEvents);
    }

    public function getEventByDate(Request $request) {
        $user_id = Auth::user()->id;
        $start = $request->start;
        $end = $request->end;
        $now = now();
        $events = Event::where('start', '>=', $start)->where('end', '<=', $end)->where('user_id', $user_id)->where('start', '>=', $now)->paginate('10');

        return response()->json($events);
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
        $create = [
            'title'=> $request->title,
            'description'=> $request->description,
            'start'=> $request->start,
            'end'=> $request->end,
            'user_id'=> Auth::user()->id,
        ];
        $event = Event::create($create);

        if (isset($event->id)){
            return response()->json(['success' => 'true']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//     public function show($id)
//     {
//         //
//     }

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
    public function update(Request $request)
    {
        $event = Event::where('id', $request->id)->first();

        if (isset($event->id)) {
            $event->update($request->all());
            return response()->json(['success' => 'true']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $event = Event::where('id', $id)->first();
        if ($event->id) {
            $event->delete();
            return response()->json(['success' => 'true']);
        }
    }
}
