<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Outlet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class OutletController extends Controller
{
    public function fetch(Request $request){
        try {
            $user = Auth::user();
            $badanusahaId = $user->badanusaha_id;
            $divisiId = $user->divisi_id;
            $regionId = $user->region_id;
            $clusterId = $user->cluster_id;
            $roleId = $user->role_id;

            $query = Outlet::with(['badanusaha','cluster','region','divisi'])
                    ->where('badanusaha_id',$badanusahaId)
                    ->where('divisi_id',$divisiId);

            switch ($roleId) {
                case 1:
                    $outlet = $query
                    ->where('cluster_id',$clusterId)
                    ->orderBy('nama_outlet')
                    ->get();
                    break;

                case 2:
                    $outlet = $query
                    ->where('region_id',$regionId)
                    ->orderBy('nama_outlet')
                    ->get();
                    break;

                default:
                    $outlet = Outlet::with(['badanusaha','cluster','region','divisi'])->get();
                    break;
            }
            

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
        error_log($nama);
        try {
            
            $outlet = Outlet::with(['badanusaha','cluster','region','divisi'])
            ->where('kode_outlet','like','%'.$nama.'%')
            ->get();
        return ResponseFormatter::success($outlet,'berhasil');
        } catch (Exception $err) {
            return ResponseFormatter::error(null,'ada kesalahan');
        }

    }

    public function updatefoto(Request $request)
    {
        try {
            $request->validate([
                'kode_outlet' => ['required'],
            ]);
    
            $data = Outlet::where('kode_outlet',$request->kode_outlet)->first();
            for($i=0;$i<=6;$i++){
                $namaFoto = $request->file('photo'.$i)->getClientOriginalName();
                if(Str::contains($namaFoto ,'fotodepan'))
                {
                    $data['poto_depan'] = $namaFoto;
                }
                else if(Str::contains($namaFoto ,'fotobelakang'))
                {
                    $data['poto_belakang'] = $namaFoto;
                }
                else if(Str::contains($namaFoto ,'fotokanan'))
                {
                    $data['poto_kanan'] = $namaFoto;
                }
                else if(Str::contains($namaFoto ,'fotokiri'))
                {
                    $data['poto_kiri'] = $namaFoto;
                }
                else if(Str::contains($namaFoto ,'fotoetalase'))
                {
                    $data['poto_etalase'] = $namaFoto;
                }
                else if(Str::contains($namaFoto ,'fotoktp'))
                {
                    $data['poto_ktp'] = $namaFoto;
                }
                else
                {
                    $data['poto_shop_sign'] = $namaFoto;
                }
                $request->file('photo'.$i)->move(storage_path('app/public/'),$namaFoto);
            }

            $data->save();

            return ResponseFormatter::success(null,'berhasil Update');
        } catch (Exception $e) {
            error_log($e);
           return ResponseFormatter::error(null,$e);
        }

    }
}
