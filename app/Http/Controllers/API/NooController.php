<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Noo;
use App\Models\User;
use App\Models\Outlet;
use App\Models\Region;
use App\Models\Cluster;
use App\Models\Division;
use App\Helpers\SendNotif;
use App\Models\BadanUsaha;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

            $query = Noo::with(['badanusaha', 'cluster', 'region', 'divisi']);

            switch ($roleId) {
                case 1:
                    $noos = $query
                        ->where('tm_id', $user->id)
                        ->latest()
                        ->get();
                    break;

                case 2:
                    $noos = $query
                        ->where('badanusaha_id', $badanusahaId)
                        ->where('divisi_id', $divisiId)
                        ->where('region_id', $regionId)
                        ->latest()
                        ->get();
                    break;

                case 3:
                    $noos = $query
                        ->where('badanusaha_id', $badanusahaId)
                        ->where('divisi_id', $divisiId)
                        ->where('region_id', $regionId)
                        ->where('cluster_id', $clusterId)
                        ->latest()
                        ->get();
                    break;

                default:
                    $noos = Noo::with(['badanusaha', 'cluster', 'region', 'divisi'])->latest()->get();
                    break;
            }



            return ResponseFormatter::success(
                $noos,
                'fetch noo success',
            );
        } catch (Exception $err) {
            return ResponseFormatter::error([
                'message' => $err,
            ], 'something wrong', 500);
        }
    }

    public function all(Request $request)
    {
        try {
            $noos = Noo::with(['badanusaha', 'cluster', 'region', 'divisi'])->get();

            return ResponseFormatter::success(
                $noos,
                'fetch noo success',
            );
        } catch (Exception $err) {
            return ResponseFormatter::error([
                'message' => $err,
            ], 'something wrong', 500);
        }
    }

    public function submit(Request $request)
    {
        try {
            $user = Auth::user();
            $data = [
                'nama_outlet' => $request->nama_outlet,
                'alamat_outlet' => $request->alamat_outlet,
                'nama_pemilik_outlet' => $request->nama_pemilik,
                'nomer_tlp_outlet' => $request->nomer_pemilik,
                'nomer_wakil_outlet' => $request->nomer_perwakilan,
                'ktp_outlet' => $request->ktpnpwp,
                'distric' => $request->distric,
                'oppo' => $request->oppo,
                'vivo' => $request->vivo,
                'samsung' => $request->samsung,
                'xiaomi' => $request->xiaomi,
                'realme' => $request->realme,
                'fl' => $request->fl,
                'latlong' => $request->latlong,
                'created_by' => $user->nama_lengkap,
                'tm_id' => $user->tm->id,
            ];
            switch ($user->role_id) {
                case 1:
                    $badanusaha_id = BadanUsaha::where('name', $request->bu)->first()->id;
                    $divisi_id = Division::where('badanusaha_id', $badanusaha_id)->where('name', $request->div)->first()->id;
                    $region_id = Region::where('badanusaha_id', $badanusaha_id)->where('divisi_id', $divisi_id)->where('name', $request->reg)->first()->id;
                    $cluster_id = Cluster::where('badanusaha_id', $badanusaha_id)->where('divisi_id', $divisi_id)->where('region_id', $region_id)->where('name', $request->clus)->first()->id;
                    $data['badanusaha_id'] = $badanusaha_id;
                    $data['divisi_id'] = $divisi_id;
                    $data['region_id'] = $region_id;
                    $data['cluster_id'] = $cluster_id;
                    break;

                case 2:
                    $data['badanusaha_id'] = $user->badanusaha_id;
                    $data['divisi_id'] = $user->divisi_id;
                    $data['region_id'] = $user->region_id;
                    $data['cluster_id'] = Cluster::where('badanusaha_id', $user->badanusaha_id)->where('divisi_id', $user->divisi_id)->where('region_id', $user->region_id)->where('name', $request->clus)->first()->id;
                    error_log($data['cluster_id']);
                    break;

                default:
                    $data['badanusaha_id'] = $user->badanusaha_id;
                    $data['divisi_id'] = $user->divisi_id;
                    $data['region_id'] = $user->region_id;
                    $data['cluster_id'] = $user->cluster_id;
                    break;
            }

            for ($i = 0; $i <= 6; $i++) {
                $namaFoto = $request->file('photo' . $i)->getClientOriginalName();
                if (Str::contains($namaFoto, 'fotodepan')) {
                    $data['poto_depan'] = $namaFoto;
                } else if (Str::contains($namaFoto, 'fotobelakang')) {
                    $data['poto_belakang'] = $namaFoto;
                } else if (Str::contains($namaFoto, 'fotokanan')) {
                    $data['poto_kanan'] = $namaFoto;
                } else if (Str::contains($namaFoto, 'fotokiri')) {
                    $data['poto_kiri'] = $namaFoto;
                } else if (Str::contains($namaFoto, 'fotoetalase')) {
                    $data['poto_etalase'] = $namaFoto;
                } else if (Str::contains($namaFoto, 'fotoktp')) {
                    $data['poto_ktp'] = $namaFoto;
                } else {
                    $data['poto_shop_sign'] = $namaFoto;
                }
                $request->file('photo' . $i)->move(storage_path('app/public/'), $namaFoto);
            }

            if ($request->hasFile('video')) {
                $name = $request->file('video')->getClientOriginalName();
                $data['video'] = 'noo-' . time() . $name;
                $request->file('video')->move(storage_path('app/public/'), 'noo-' . time() . $name);
            }

            switch ($user->id) {
                case 1:
                    $notifId = array();
                    array_push($notifId, User::where('role_id', 4)->first()->id_notif);
                    break;
                case 2:
                    $notifId = array();
                    #notif ar
                    array_push($notifId, User::where('role_id', 4)->first()->id_notif);
                    #notif tm
                    array_push($notifId, $user->tm->id_notif);
                    break;
                default:
                    $notifId = array();
                    #notif ar
                    array_push($notifId, User::where('role_id', 4)->first()->id_notif);
                    #notif tm
                    array_push($notifId, $user->tm->id_notif);
                    #notif asc
                    $asc = User::where('role_id', 2)->where('divisi_id', $user->divisi_id)->where('region_id', $user->region_id)->first()->id_notif ?? null;
                    if ($asc) {
                        array_push($notifId, $asc);
                    }
                    break;
            }
            $insert = Noo::create($data);
            if ($insert && count($notifId) != 0) {
                SendNotif::sendMessage('Noo baru ' . $request->nama_outlet . ' ditambahkan oleh ' . Auth::user()->nama_lengkap, $notifId);
            }
            return ResponseFormatter::success(null, 'berhasil menambahkan NOO ' . $request->nama_outlet);
        } catch (Exception $e) {
            error_log($e);
            return ResponseFormatter::error($e, 'gagal');
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

            $noo = Noo::findOrFail($request->id);
            $noo->status = $request->status;
            $noo->limit = $request->limit;
            $noo->kode_outlet = $request->kode_outlet;
            $noo->confirmed_by = Auth::user()->nama_lengkap;
            $noo->confirmed_at = now();
            $noo->update();
            SendNotif::sendMessage(
                'Noo ' . $noo->nama_outlet . ' sudah di konfirmasi oleh ' .
                    Auth::user()->nama_lengkap . PHP_EOL .
                    'Dengan limit : Rp ' . number_format($request->limit, 0, ',', '.'),
                array(User::where('nama_lengkap', $noo->created_by)->first()->id_notif ?? '-', $noo->tm->id_notif)

            );
            return ResponseFormatter::success($noo, 'berhasil update');
        } catch (Exception $e) {
            error_log($e);
            return ResponseFormatter::error($e, 'gagal');
        }
    }

    public function approved(Request $request)
    {
        try {

            $request->validate([
                'id' => ['required'],
                'status' => ['required'],
            ]);

            $noo = Noo::find($request->id);
            $noo->status = $request->status;
            $noo->approved_by = Auth::user()->nama_lengkap;
            $noo->approved_at = now();
            $noo->update();

            $notif = array();
            $register = User::where('nama_lengkap', $noo->created_by)->first()->id_notif;
            if ($register) {
                array_push($notif, $register);
            }

            $data = [
                'kode_outlet' => $noo->kode_outlet,
                'badanusaha_id' => $noo->badanusaha_id,
                'nama_outlet' => $noo->nama_outlet,
                'divisi_id' => $noo->divisi_id,
                'alamat_outlet' => $noo->alamat_outlet,
                'nama_pemilik_outlet' => $noo->nama_pemilik_outlet,
                'nomer_tlp_outlet' => $noo->nomer_tlp_outlet,
                'distric' => $noo->distric,
                'region_id' => $noo->region_id,
                'cluster_id' => $noo->cluster_id,
                'poto_shop_sign' => $noo->poto_shop_sign,
                'poto_etalase' => $noo->poto_etalase,
                'poto_depan' => $noo->poto_depan,
                'poto_kanan' => $noo->poto_kanan,
                'poto_kiri' => $noo->poto_kiri,
                'poto_belakang' => $noo->poto_belakang,
                'poto_ktp' => $noo->poto_ktp,
                'video' => $noo->video,
                'radius' => 0,
                'latlong' => $noo->latlong,
                'status_outlet' => 'MAINTAIN',
                'limit' => $noo->limit,
            ];
            $outletExisting = Outlet::where('badanusaha_id', $noo->badanusaha_id)
                ->where('divisi_id', $noo->divisi_id)
                ->where('region_id', $noo->region_id)
                ->where('cluster_id', $noo->cluster_id)
                ->where('kode_outlet', $noo->kode_outlet)->first();
            if ($outletExisting) {
                return ResponseFormatter::success($noo, 'berhasil update');
            } else {
                $insert = Outlet::create($data);
            }
            if (count($notif) != 0 && $insert) {
                SendNotif::sendMessage(
                    'Noo ' . $noo->nama_outlet . ' sudah di setujui oleh ' .
                        Auth::user()->nama_lengkap,
                    $notif
                );
            }
            return ResponseFormatter::success($noo, 'berhasil update');
        } catch (Exception $e) {
            error_log($e);
            return ResponseFormatter::error($e, 'gagal');
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

            $noo = Noo::findOrFail($request->id);
            $noo->status = $request->status;
            $noo->keterangan = $request->alasan;
            $noo->rejected_by = Auth::user()->nama_lengkap;
            $noo->rejected_at = now();

            $noo->update();

            SendNotif::sendMessage('Noo ' . $noo->nama_outlet . ' ditolak oleh ' . Auth::user()->nama_lengkap . PHP_EOL . 'Alasan : ' . $request->alasan, array($noo->tm->id_notif));

            return ResponseFormatter::success($noo, 'berhasil update');
        } catch (Exception $e) {
            return ResponseFormatter::error($e, 'gagal');
        }
    }

    public function getbu(Request $request)
    {
        try {
            $badanusahas = BadanUsaha::all();
            return ResponseFormatter::success($badanusahas, 'berhasil');
        } catch (Exception $e) {
            return ResponseFormatter::error([], $e->getMessage());
        }
    }

    public function getdiv(Request $request)
    {
        try {
            $badanusaha_id = BadanUsaha::where('name', $request->bu)->first()->id;
            $divisi = Division::where('badanusaha_id', $badanusaha_id)->get();
            return ResponseFormatter::success($divisi, 'berhasil');
        } catch (Exception $e) {
            return ResponseFormatter::error([], $e->getMessage());
        }
    }

    public function getreg(Request $request)
    {
        try {
            $badanusaha_id = BadanUsaha::where('name', $request->bu)->first()->id;
            $divisi_id = Division::where('badanusaha_id', $badanusaha_id)->where('name', $request->div)->first()->id;
            $region = Region::where('badanusaha_id', $badanusaha_id)->where('divisi_id', $divisi_id)->get();
            return ResponseFormatter::success($region, 'berhasil');
        } catch (Exception $e) {
            return ResponseFormatter::error([], $e->getMessage());
        }
    }

    public function getclus(Request $request)
    {
        try {
            if ($request->role) {
                $user = Auth::user();
                $cluster = Cluster::where('badanusaha_id', $user->badanusaha_id)->where('divisi_id', $user->divisi_id)->where('region_id', $user->region_id)->get();
            } else {
                $badanusaha_id = BadanUsaha::where('name', $request->bu)->first()->id;
                $divisi_id = Division::where('badanusaha_id', $badanusaha_id)->where('name', $request->div)->first()->id;
                $region_id = Region::where('badanusaha_id', $badanusaha_id)->where('divisi_id', $divisi_id)->where('name', $request->reg)->first()->id;
                $cluster = Cluster::where('badanusaha_id', $badanusaha_id)->where('divisi_id', $divisi_id)->where('region_id', $region_id)->get();
            }
            return ResponseFormatter::success($cluster, 'berhasil');
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), $e->getMessage());
        }
    }
}
