<?php

namespace App\Http\Controllers;

use App\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->exists('query') && $request->query == true)
        {
            $parameters = $request->only([
                'url',
                'songname',
                'artistid',
                'artistname',
                'albumid',
                'albumname'
            ]);

            if ($request->exists('advanced') && $request->advanced == true)
            {
                $query = Song::query();

                foreach (array_filter($parameters) as $column => $values) {
                    $query->where($column, 'LIKE', '%'. $values . '%');
                }

                $result = $query->get();

            }else{

                $result = Song::where(array_filter($parameters))->get();
            }

            if ($result->isEmpty())
            {
                return response(null, 404);
            }
            return response()->json($result, 200);
        }

        return Song::all();
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
        $validator = Validator::make($request->all(),
            [
                'url'       =>'required',
                'songname'  =>'required',
                'artistid'  =>'required',
                'artistname'=>'required',
                'albumid'   =>'required',
                'albumname' =>'required'
            ]);

        if ($validator->fails())
        {
            return response($validator->errors(), 409);
        }

        $parameters = $request->only([
            'url',
            'songname',
            'artistid',
            'artistname',
            'albumid',
            'albumname'
        ]);

        return Song::firstOrCreate($parameters);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function show(Song $song)
    {
        return $song;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function edit(Song $song)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Song $song)
    {
        $parameters = $request->only([
            'url',
            'songname',
            'artistid',
            'artistname',
            'albumid',
            'albumname'
        ]);

        $song->update($parameters);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Song  $song
     * @return \Illuminate\Http\Response
     */
    public function destroy(Song $song)
    {
        $song->delete();
    }
}
