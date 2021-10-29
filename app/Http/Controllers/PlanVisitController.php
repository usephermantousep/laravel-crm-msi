<?php

namespace App\Http\Controllers;

use App\Exports\PlanVisitExport;
use App\Models\PlanVisit;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PlanVisitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $planVisits = PlanVisit::with(['user','outlet'])->orderBy('tanggal_visit','desc')->paginate(10);
        return view('planvisit.index',[
            'planVisits' => $planVisits,
            'title' => 'Plan Visit',
            'active' => 'planvisit',
        ]);
    }

    public function export(Request $request)
    {
        if($request->tanggal1 && $request->tanggal2)
        {
            return Excel::download(new PlanVisitExport($request->tanggal1,$request->tanggal2),'planvisit.xlsx');
        }else{
            // $planVisits = PlanVisit::with(['user','outlet'])->orderBy('tanggal_visit','desc')->paginate(10);
            // return view('planvisit.index',[
            //     'planVisits' => $planVisits,
            //     'title' => 'Plan Visit',
            //     'active' => 'planvisit',
            // ]);
            $this->index();
        }
    }
}
