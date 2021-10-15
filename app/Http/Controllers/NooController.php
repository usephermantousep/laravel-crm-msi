<?php

namespace App\Http\Controllers;

use App\Exports\NooExport;
use App\Models\Noo;
use Maatwebsite\Excel\Facades\Excel;

class NooController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $noos = Noo::with(['badanusaha','cluster','region','divisi'])->latest()->filter()->get();
        return view('noo.index',[
            'noos' => $noos,
            'title' => 'NOO',
            'active' => 'noo',
        ]);
    }

    public function export()
    {
        return Excel::download(new NooExport,'noo.xlsx');
    }
}
