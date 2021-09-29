<?php

namespace App\Http\Controllers;

use App\Models\Noo;
use App\Models\User;
use App\Models\Visit;
use App\Models\Outlet;
use App\Models\PlanVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = count(User::all());
        $outlet = count(Outlet::all());
        $noo = count(Noo::all());
        $visit = count(Visit::all());
        $planvisit = count(PlanVisit::all());
        return view('dashboard.index',[
            'user' => $user,
            'outlet' => $outlet,
            'noo' => $noo,
            'visit' => $visit,
            'planvisit' => $planvisit,
            'title' => 'DASHBOARD'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/masuk');
    }
}
