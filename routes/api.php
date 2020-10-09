<?php

use App\Category;
use App\BoardMeeting;
use App\CommitteeMeeting;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/events/json', function (Request $request) {

    $start = $request->input('start');
    $end = $request->input('end');

    $meetings = BoardMeeting::where([
        ['date', '>=', $start],
        ['date', '<=', $end],
    ])->get();

    $events = collect([]);

    foreach ($meetings as $meeting) {
        $event = collect($meeting);
        $event->put('title', $meeting->name . " Board Meeting");
        $url = $meeting->status == 'over' ? "/board/meeting/$meeting->id" : "/board/meeting";
        $event->put('url', $url);
        $events->push($event);
    }

    $meetings = CommitteeMeeting::where([
        ['date', '>=', $start],
        ['date', '<=', $end],
    ])->get();

    foreach ($meetings as $meeting) {
        $event = collect($meeting);
        $event->put('title', $meeting->name . $meeting->committee->name . " Meeting");
        $url = $meeting->status == 'over' ? "/archive/$meeting->id" : "/committee/meeting/user/$meeting->committee_id";
        $event->put('url', $url);
        $events->push($event);
    }

    return $events;
});

Route::middleware('auth:api')->get('/categories', function (Request $request) {
    return Category::with('remarks')->get();
});

Route::middleware('auth:api')->get('/board/meeting', function (Request $request) {
    return BoardMeeting::where('status', 'scheduled')->first();
});
