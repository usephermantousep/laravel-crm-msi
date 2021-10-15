<?php

namespace App\Http\Controllers;

use App\Exports\VisitExport;
use App\Models\Visit;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visits = Visit::all();
        return view('visit.index',[
            'visits' => $visits,
            'title' => 'Visit',
            'active' => 'visit',
        ]);
    }

    public function export(Request $request)
    {
        if($request->tanggal1 && $request->tanggal2)
        {
            return Excel::download(new VisitExport($request->tanggal1,$request->tanggal2),'visit.xlsx');
        }else{
            $visits = Visit::all();
            return view('visit.index',[
                'visits' => $visits,
                'title' => 'Visit',
                'active' => 'visit',
        ]);
        }
    }
}
