<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Outlet;
use App\Models\PlanVisit;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanVisitController extends Controller
{
    public function fetch(Request $request)
    {
        try {
            $planVisit = PlanVisit::with(
                [
                    'outlet.badanusaha',
                    'outlet.region',
                    'outlet.divisi',
                    'outlet.cluster',
                    'user.badanusaha',
                    'user.region',
                    'user.divisi',
                    'user.cluster',
                    'user.role'
                ])
                ->where('user_id',Auth::user()->id)
                ->whereDate('tanggal_visit',date('Y-m-d'))
                ->get();

            return ResponseFormatter::success(
                $planVisit,'ok');
        } catch (Exception $err) {
            return ResponseFormatter::error([
                'message' => $err
            ],$err,500);
        }
    }

    public function bymonth(Request $request)
    {
        try {
            $request->validate([
                'bulan' => ['required','string'],
                'tahun' => ['required','string'],
            ]);
            $plan = PlanVisit::with([
                'outlet.badanusaha',
                'outlet.region',
                'outlet.divisi',
                'outlet.cluster',
                'user.badanusaha',
                'user.region',
                'user.divisi',
                'user.cluster',
                'user.role'
            ])
            ->whereYear('tanggal_visit','=',$request->tahun)
            ->whereMonth('tanggal_visit','=',$request->bulan)
            ->where('user_id',Auth::user()->id)
            ->orderBy('tanggal_visit')
            ->get();
            return ResponseFormatter::success($plan,'berhasil');
        } catch (Exception $e) {
            return ResponseFormatter::error(null,$e);
        }

    }

    public function add(Request $request)
    {
        try {
            $request->validate([
                'tanggal_visit' => ['required','date'],
                'kode_outlet' => ['required'],
            ]);

            $idOutlet = Outlet::where('kode_outlet',$request->kode_outlet)->first();
            ##cek apakah sudah ada data dengan user, outlet dan tanggal yang dikirim
            $cekData = PlanVisit::whereDate('tanggal_visit',Carbon::parse($request->tanggal_visit))
            ->where('user_id',Auth::user()->id)
            ->where('outlet_id',$idOutlet->id)
            ->first();
            if($cekData)
            {
                return ResponseFormatter::error($cekData,'data sebelumnya sudah ada');
            }
            $addPlan = PlanVisit::insert([
                'user_id' =>(string) Auth::user()->id,
                'outlet_id' => $idOutlet->id,
                'tanggal_visit' => Carbon::parse($request->tanggal_visit),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            return ResponseFormatter::success($addPlan,'berhasil');
        } catch (Exception $e) {
           return ResponseFormatter::error(null,$e);
        }

    }

    public function delete(Request $request)
    {
        try {
            $validation = $request->validate([
                'bulan' => 'required',
                'tahun' => 'required',
                'kode_outlet' => 'required',
            ]);

            $outletId = Outlet::where('kode_outlet',$request->kode_outlet)->first()->id;

            if(!$validation)
            {
                return ResponseFormatter::error(null,$validation,422);
            }

            $delete = PlanVisit::where('outlet_id',$outletId)
                                ->whereYear('tanggal_visit',$request->tahun)
                                ->whereMonth('tanggal_visit',$request->bulan)
                                ->where('user_id',Auth::user()->id)
                                ->delete();

            if(!$delete)
            {
                return ResponseFormatter::error(null,$validation,422);

            }

            return ResponseFormatter::success($delete,'berhasil');
        }
        catch (Exception $e)
        {
            error_log($e);
            return ResponseFormatter::error($e,'error',422);

        }
    }
}

