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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NooController extends Controller
{
    public function fetch(Request $request)
    {
        try {
            $user = Auth::user();
            $badanusahaId = $user->badanusaha_id;
            $divisiId = $user->divisi_id;
            $regionId = $user->region_id;
            $clusterId = $user->cluster_id;
            $roleId = $user->role_id;

            $query = Noo::with(['badanusaha','cluster','region','divisi'])
                    ->where('badanusaha_id',$badanusahaId)
                    ->where('divisi_id',$divisiId);
            
            switch ($roleId) {
                case 1:
                    $noos = $query
                    ->where('cluster_id',$clusterId)
                    ->latest()
                    ->get();
                    break;

                case 2:
                    $noos = $query
                    ->where('region_id',$regionId)
                    ->latest()
                    ->get();
                    break;
                    
                default:
                    $noos = Noo::with(['badanusaha','cluster','region','divisi'])->latest()->get();
                    break;
            }

            

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
            $noos = Noo::with(['badanusaha','cluster','region','divisi'])->get();

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
            $user = Auth::user();
            $data = [
                'badanusaha_id' => $user->badanusaha_id,
                'divisi_id' => $user->divisi_id,
                'nama_outlet' => $request->nama_outlet,
                'alamat_outlet' => $request->alamat_outlet,
                'nama_pemilik_outlet' => $request->nama_pemilik,
                'nomer_tlp_outlet' => $request->nomer_pemilik,
                'nomer_wakil_outlet' => $request->nomer_perwakilan,
                'ktp_outlet' => $request->ktpnpwp,
                'kota' => $request->kota,
                'region_id' => $user->region_id,
                'cluster_id' => $user->cluster_id,
                'oppo' => $request->oppo,
                'vivo' => $request->vivo,
                'samsung' => $request->samsung,
                'xiaomi' => $request->xiaomi,
                'realme' => $request->realme,
                'fl' => $request->fl,
                'latlong' => $request->latlong,
                'created_by' => $user->nama_lengkap
            ];

            if ($user->role_id == 2) {
                $cluster = Cluster::where('name',$request->cluster)->first();
                $data['cluster_id'] = $cluster->id;
            }
            

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

            if($request->hasFile('video'))
            {
                $name = $request->file('video')->getClientOriginalName();
                $data['video'] = 'noo-'.time().$name;
                $request->file('video')->move(storage_path('app/public/'),'noo-'.time().$name);
            }
            Noo::create($data);

            $ids = User::whereIn('role_id',[3.4])->get();

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
            
            $request->validate([
                'id' => ['required'],
                'status' => ['required'],
                'limit' => ['required'],
                'kode_outlet' => ['required'],
            ]);

            $noo = Noo::find($request->id);
            $noo->status = $request->status;
            $noo->limit = $request->limit;
            $noo->kode_outlet = $request->kode_outlet;
            $noo->approved_by = Auth::user()->nama_lengkap;
            $noo->approved_at = now();
            $noo->update();
            SendNotif::sendMessage(
                'Noo '.$noo->nama_outlet.' sudah di setujui oleh '.
                Auth::user()->nama_lengkap.PHP_EOL.
                'Dengan limit : Rp '.number_format($request->limit,0,',','.'), 
                User::where('badanusaha_id',$noo->badan_usaha_id)
                ->where('divisi_id',$noo->divisi_id)
                ->where('region_id',$noo->region_id)
                ->where('nama_lengkap',$noo->created_by)->first()->id_notif ?? '-');
            $data = [
                'kode_outlet' => $noo->kode_outlet,
                'badanusaha_id' => $noo->badanusaha_id,
                'nama_outlet' => $noo->nama_outlet,
                'divisi_id' => $noo->divisi_id,
                'alamat_outlet' => $noo->alamat_outlet,
                'nama_pemilik_outlet'=> $noo->nama_pemilik_outlet,
                'nomer_tlp_outlet' => $noo->nomer_tlp_outlet,
                'region_id' => $noo->region_id,
                'cluster_id' => $noo->cluster_id,
                'poto_shop_sign' => $noo->poto_shop_sign,
                'poto_etalase' => $noo->poto_etalase,
                'poto_depan' => $noo->poto_depan,
                'poto_kanan' => $noo->poto_kanan,
                'poto_kiri' => $noo->poto_kiri,
                'poto_belakang' => $noo->poto_belakang,
                'poto_ktp' => $noo->poto_ktp,
                'radius' => 0,
                'latlong' => $noo->latlong,
                'status_outlet' => 'MAINTAIN',
                'limit' => $noo->limit,
            ];
            Outlet::create($data);
            return ResponseFormatter::success($noo,'berhasil update');

        } catch (Exception $e) {
            error_log($e);
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
            $noo->rejected_at = now();

            $noo->update();

            SendNotif::sendMessage('Noo '.$noo->nama_outlet.' ditolak oleh '.Auth::user()->nama_lengkap.PHP_EOL. 'Alasan : '. $request->alasan  , $noo->user->id_notif);

            return ResponseFormatter::success($noo,'berhasil update');
        } catch (Exception $e) {
            return ResponseFormatter::error($e,'gagal');
        }
    }
}
