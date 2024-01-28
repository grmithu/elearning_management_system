<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->date;
        $events = Event::when($request->date, function($query) use ($request) {
            return $query->whereDate('start_time', $request->date);
        })->orderBy('start_time', 'asc')
            ->paginate(15, ['*'], 'page');

        return view('event.index', compact('events', 'date'));
    }
    public function create()
    {
        if (auth()->user()->type != 'admin') return abort(401);

        return view('event.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->type != 'admin') return abort(401);

        if ($request->thumbnail) {
            $tmpName = str_replace(' ', '_', $request->thumbnail->getClientOriginalName());
            $thumbnailName = time() . '_' . $tmpName;
            if (env('APP_ENV') == 'local') {
                $request->thumbnail->move(public_path('images/events/'), $thumbnailName);
            } else {
                $request->thumbnail->move('images/events/', $thumbnailName);
            }
        } else $thumbnailName = 'default.jpg';

        Event::create([
            'title'         => $request->event_title,
            'description'   => $request->description,
            'start_time'    => $request->start_time,
            'location'      => $request->event_location,
            'thumbnail'     => $thumbnailName
        ]);

        return redirect()->route('event.index');
    }

    public function ajaxGetEventCount()
    {
        $events = Event::all();
        $data = [];

        foreach ($events as $event) {
            $data[] = [
                'date' => Carbon::parse($event->start_time)->format('Y-m-d'),
            ];
        }

        $count = array_count_values(array_column($data, 'date'));
        $calendarData = [];

        foreach ($count as $date => $value) {
            $calendarData[] = [
                'title' => $value,
                'start'  => $date,
            ];
        }

        return response()->json($calendarData);
    }
}
