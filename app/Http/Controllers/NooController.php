<?php

namespace App\Http\Controllers;

use App\Models\Noo;
use Illuminate\Http\Request;

class NooController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $noos = Noo::latest()->filter()->get();
        return view('noo.index',[
            'noos' => $noos,
            'title' => 'NOO'
        ]);
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
     * @param  \App\Models\noo  $noo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\noo  $noo
     * @return \Illuminate\Http\Response
     */
    public function edit(noo $noo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\noo  $noo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, noo $noo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\noo  $noo
     * @return \Illuminate\Http\Response
     */
    public function destroy(noo $noo)
    {
        //
    }
}
