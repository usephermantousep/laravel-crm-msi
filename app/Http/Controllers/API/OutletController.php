<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Outlet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OutletController extends Controller
{
    public function fetch(Request $request){
        try {
            $outlet = Outlet::with(['cluster','user.cluster'])
            ->where('cluster_id',Auth::user()
            ->cluster->id)->orderBy('nama_outlet')
            ->get();

            return ResponseFormatter::success(
                $outlet,
                'fetch outlet berhasil'
            );
        } catch (Exception $e) {
            return ResponseFormatter::error([
                'message' => 'ada yang salah',
                'error' => $e
            ],'ERROR',500);
        }
    }

    public function addOutlet(Request $request){
        try{
            $request->validate([
                'user_id' => ['required','integer'],
                'nama_outlet' => ['required','min:3'],
                'alamat_outlet' => ['required','string'],
                'nama_pemilik_outlet' => ['required','string'],
                'nomer_tlp_outlet' => ['required','string'],
                'region' => ['required','min:2'],
                'cluster' => ['required'],
                'latlong' => ['required'],
                'radius' => ['required','integer'],
                'status_outlet' => ['required','string']
            ]);
            $data = $request->all();
            $outlet = Outlet::create($data);
            return ResponseFormatter::success([
                    'outlet' => $outlet
                ],'berhasil simpan outlet');
        } catch (Exception $e) {
            return ResponseFormatter::error([
                'message' => 'ada yang salah',
                'error' => $e
            ],'ERROR',500);
        }

    }

    public function singleOutlet(Request $request,$nama)
    {
        try {
            $outlet = Outlet::with(['user.cluster','cluster'])
            ->where('nama_outlet',$nama)
            ->get();
        return ResponseFormatter::success($outlet,'berhasil');
        } catch (Exception $err) {
            return ResponseFormatter::error(null,'ada kesalahan');
        }

    }
}
