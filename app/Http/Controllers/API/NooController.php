<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Noo;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Helpers\SendNotif;
use App\Http\Controllers\Controller;
use App\Models\Cluster;
use App\Models\Outlet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NooController extends Controller
{
    public function fetch(Request $request)
    {
        try {
            $noos = Noo::with(['user.cluster','cluster'])
            ->where('user_id',Auth::user()->id)
            ->get();

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

    public function all(Request $request)
    {
        try {
            $noos = Noo::with(['user.cluster','cluster'])->get();

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

            $ids = User::whereIn('roles',['AR','DSM'])->get();

            $idNotif = array();
            foreach ($ids as $id)
            {
            $idNotif[] = $id->id_notif;
            }
            $notifId = implode(',',$idNotif);

            SendNotif::sendMessage('Noo baru '.$request->nama_outlet.' ditambahkan oleh '.Auth::user()->nama_lengkap, $notifId);
            return ResponseFormatter::success(null,'berhasil menambahkan NOO '.$request->nama_outlet);
        } catch (Exception $e) {
            error_log($e);
            return ResponseFormatter::error($e,'gagal');
        }

    }

    public function confirm(Request $request)
    {
        try {
            if(Auth::user()->roles == 'AR'){
                $request->validate([
                    'id' => ['required'],
                    'status' => ['required'],
                    'limit' => ['required'],
                ]);

                $noo = Noo::find($request->id);
                $noo->status = $request->status;
                $noo->limit = (int) $request->limit;
                $noo->confirmed_by = Auth::user()->nama_lengkap;
                $noo->confirmed_at = Carbon::now();

                $idDsm = User::where('roles','DSM')->first();

                SendNotif::sendMessage('Noo '.$noo->nama_outlet.' sudah di konfirmasi oleh '.Auth::user()->nama_lengkap.PHP_EOL. 'limit outlet Rp ' .number_format($noo->limit,0,',','.')  , $noo->user->id_notif);
                SendNotif::sendMessage('Noo '.$noo->nama_outlet.' sudah di konfirmasi oleh '.Auth::user()->nama_lengkap.PHP_EOL. 'limit outlet Rp ' .number_format($noo->limit,0,',','.'). ' dan butuh persetujuan oleh DSM', $idDsm->id_notif);

            }else{
                $request->validate([
                    'id' => ['required'],
                    'status' => ['required'],
                ]);

                $noo = Noo::find($request->id);
                $noo->status = $request->status;
                $noo->approved_by = Auth::user()->nama_lengkap;
                $noo->approved_at = Carbon::now();
                SendNotif::sendMessage('Noo '.$noo->nama_outlet.' sudah di setujui oleh '.Auth::user()->nama_lengkap, $noo->user->id_notif);
                $data = [
                    'user_id' => $noo->user_id,
                    'nama_outlet' => $noo->nama_outlet,
                    'alamat_outlet' => $noo->alamat_outlet,
                    'nama_pemilik_outlet'=> $noo->nama_pemilik_outlet,
                    'nomer_tlp_outlet' => $noo->nomer_tlp_outlet,
                    'region' => $noo->region,
                    'cluster_id' => $noo->cluster_id,
                    'radius' => 50,
                    'latlong' => $noo->latlong,
                    'status_outlet' => 'MAINTAIN',
                ];
                Outlet::create($data);
            }
            $noo->update();

            return ResponseFormatter::success($noo,'berhasil update');

        } catch (Exception $e) {
            return ResponseFormatter::error($e,'gagal');

        }

    }

    public function reject(Request $request)
    {
        try {
            $request->validate([
                'id' => ['required'],
                'status' => ['required'],
                'alasan' => ['required'],
            ]);

            $noo = Noo::find($request->id);
            $noo->status = $request->status;
            $noo->keterangan = $request->alasan;
            $noo->rejected_by = Auth::user()->nama_lengkap;
            $noo->rejected_at = Carbon::now();

            $noo->update();

            SendNotif::sendMessage('Noo '.$noo->nama_outlet.' ditolak oleh '.Auth::user()->nama_lengkap.PHP_EOL. 'Alasan : '. $request->alasan  , $noo->user->id_notif);

            return ResponseFormatter::success($noo,'berhasil update');
        } catch (Exception $e) {
            return ResponseFormatter::error($e,'gagal');
        }
    }
}
