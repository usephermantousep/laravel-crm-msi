<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Noo;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Cluster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NooController extends Controller
{
    public function fetch(Request $request)
    {
        try {
            $noos = Noo::with(['user.cluster','cluster'])->where('user_id',Auth::user()->id)->get();

            return ResponseFormatter::success(
                $noos,
                'fetch noo success',
            );


        } catch (Exception $err) {
            return ResponseFormatter::error([
                'message' => $err,
            ],'something wrong',500);
        }
    }

    public function submit(Request $request)
    {
        try {
            $cluster = Cluster::where('name',$request->cluster)->first();

            $data = [
                'user_id' => Auth::user()->id,
                'nama_outlet' => $request->nama_outlet,
                'alamat_outlet' => $request->alamat_outlet,
                'nama_pemilik_outlet' => $request->nama_pemilik,
                'nomer_tlp_outlet' => $request->nomer_pemilik,
                'nomer_wakil_outlet' => $request->nomer_perwakilan,
                'ktp_outlet' => $request->ktpnpwp,
                'kota' => $request->kota,
                'region' => $cluster->region,
                'cluster_id' => $cluster->id,
                'oppo' => $request->oppo,
                'vivo' => $request->vivo,
                'samsung' => $request->samsung,
                'xiaomi' => $request->xiaomi,
                'realme' => $request->realme,
                'fl' => $request->fl,
                'latlong' => $request->latlong,
            ];

            for($i=0;$i<=5;$i++){
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
                else
                {
                    $data['poto_shop_sign'] = $namaFoto;
                }
                $request->file('photo'.$i)->move(storage_path('app/public/'),$namaFoto);
            }

            if($request->hasFile('video'))
            {
                $name = $request->file('video')->getClientOriginalName();
                $data['video'] = 'noo-'.time().$name;
                $request->file('video')->move(storage_path('app/public/'),'noo-'.time().$name);
            }
            Noo::create($data);
            return ResponseFormatter::success(null,'berhasil');
        } catch (Exception $e) {
            error_log($e);
            return ResponseFormatter::error($e,'gagal');
        }

    }

}
