<?php

namespace App\Http\Controllers;

use App\User;
use App\Query;
use App\Jobs\QueryJob;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QueryController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $queries = Query::with('raisedBy')->get();

        return view('query.index', compact('queries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Query::create([
            'body' => $request->body,
            'raised_by' => Auth::user()->id,
        ]);

        $msg = $request->body;
        $msg = str_replace(" ", "+", $msg);

        if(config('app.company') == 'otpc')
            $cs = [1,3];
        else if(config('app.company') == 'ompl')
            $cs = [1,2];
        else if(config('app.company') == 'ovl')
            $cs = [1,2];
        else 
            $cs = [1];

        $mobile = join("+",User::find($cs)->pluck('mobile')->toArray());
        //$url = "http://10.205.48.190:13013/cgi-bin/sendsms?username=ongc&password=ongc12&from=ONGC&to=$mobile&text=$msg&charset=UTF-8";

        $client = new Client();
        //$client->request('GET', $url);

        //QueryJob::dispatch($request->body, $cs); 

        return redirect()->back()->with('success', 'Your query has been send to the Company Secretary!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Query  $query
     * @return \Illuminate\Http\Response
     */
    public function show(Query $query)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Query  $query
     * @return \Illuminate\Http\Response
     */
    public function edit(Query $query)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Query  $query
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Query $query)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Query  $query
     * @return \Illuminate\Http\Response
     */
    public function destroy(Query $query)
    {
        //
    }
}
