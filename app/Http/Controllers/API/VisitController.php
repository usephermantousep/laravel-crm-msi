<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Outlet;
use App\Models\Visit;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitController extends Controller
{
    public function fetch(Request $request)
    {
        try {

            $visit = Visit::with([
                'outlet.badanusaha',
                'outlet.region',
                'outlet.divisi',
                'outlet.cluster',
                'user.badanusaha',
                'user.region',
                'user.divisi',
                'user.cluster',
                'user.role'])
            ->where('user_id',Auth::user()->id)
            ->whereDate('tanggal_visit',today())
            ->latest()
            ->get();

            return ResponseFormatter::success($visit,'fetch visit succes');
        } catch (Exception $err) {
            return ResponseFormatter::error([
                'message' => $err,
            ],$err,500);
        }

    }

    public function check(Request $request)
    {
        $request->validate([
            'kode_outlet' => ['required'],
        ]);

        $outlet = Outlet::where('kode_outlet',$request->kode_outlet)->first();
        $outletId= $outlet->id;

        ##cek database terkahir dari tanggal sekarang dan user tersebut
        $lastDataVisit = Visit::whereDate('tanggal_visit',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->first();
        ##cek data terkahir durasi
        if ($lastDataVisit)
        {
            if($lastDataVisit->durasi_visit){
                $isExistingLastDurasi = true;
            }
            $isExistingLastDurasi = false;
        }
        else
        {
            $isExistingLastDurasi = false;
        }
        ##cek table dengan outlet yang dikirim dan tanggal hari ini
        // $lastDataSelectedOutletVisit = Visit::with(['outlet.cluster','outlet.user.cluster'])->whereDate('tanggal_visit',date('Y-m-d'))->where('user_id',Auth::user()->id)->where('outlet_id',$outletId)->first();

        ##kalo mode ci
        if($request->check_in)
        {
            //cek apa ada data terakhir kosong ?
            if($lastDataVisit)
            {
                // if($lastDataSelectedOutletVisit)
                // {
                //     return ResponseFormatter::error(null,'anda sudah check in hari ini di outlet '. $lastDataSelectedOutletVisit->outlet->kode_outlet);
                // }
                // else
                if($lastDataVisit->durasi_visit)
                {
                    return ResponseFormatter::success(null,'ok');
                }
                else{
                     //notif error
                     return ResponseFormatter::error([
                        'message' => 'error'
                        ],"Belum check out dari outlet ". $lastDataVisit->outlet->kode_outlet,400);
                }
            }
            else
            {
                return ResponseFormatter::success(null,'ok');
            }
        }
        ##disini co
        else
        {
            #kalau belum ada durasi maka bernilai true
            if(!$isExistingLastDurasi)
            {
                // ##kalau ada histori outlet tersebut di hari ini maka bernilai true
                // if($lastDataSelectedOutletVisit)
                // {
                //     ##kalau outlet tersebut sudah ada durasi visit bernilai true
                //     if($lastDataSelectedOutletVisit->durasi_visit)
                //     {
                //         return ResponseFormatter::error([
                //                 'data' => 'anda sudah checkout'
                //                 ],'anda hari ini sudah check out di outlet '.$lastDataSelectedOutletVisit->outlet->kode_outlet,400);
                //     }
                // }
                ##cek data last visit hari ini bernilai true jika ada
                // else
                if($lastDataVisit)
                {
                    ##cek dari data terkahir visit apakah ada durasi visit dan sama outlet id nya dengan yang dikirim jika keduanya salah maka bernilai true
                    if($lastDataVisit->durasi_visit == null && $lastDataVisit->outlet_id != $outletId)
                    {
                        return ResponseFormatter::error([
                                'message' => 'error'
                                ],"Belum check out dari outlet ". $lastDataVisit->outlet->kode_outlet,400);
                    }
                    else
                    {
                        if($lastDataVisit->outlet_id == $outletId)
                        {
                            return ResponseFormatter::success(null,'ok');
                        }
                            ##jika belum ci dimanapun
                            return  ResponseFormatter::error([
                                'data' => 'anda belum checkin'
                                ],'anda belum check in di outlet manapun ',400);
                    }
                }

            }
            else
            {
                ##jika belum ci dimanapun
                return  ResponseFormatter::error([
                    'data' => 'anda belum checkin'
                    ],'anda belum check in di outlet manapun ',400);
            }
            if(!$lastDataVisit)
            {
                 ##jika belum ci dimanapun
                return  ResponseFormatter::error([
                    'data' => 'anda belum checkin'
                    ],'anda belum check in di outlet manapun ',400);
            }
            return ResponseFormatter::success(null,'ok');
        }
    }

    public function submit(Request $request)
    {
        try {

            $checkIn = $request->latlong_in;
            $checkOut = $request->latlong_out;


            #aturan checkin
            if($checkIn)
            {
                $outlet = Outlet::where('kode_outlet',$request->kode_outlet)->first();
                $outletId = $outlet->id;
                #validasi data
                $request->validate([
                    'kode_outlet' => ['required'],
                    'picture_visit' => ['required','mimes:jpg,jpeg,png'],
                    'latlong_in' => ['required','string'],
                    'tipe_visit' => ['required'],
                ]);


                ##buat nama gambar
                $imageName = Carbon::parse(time())->getPreciseTimestamp(3).'-'.Auth::user()->username.'-'.'IN-'.date('Y-m-d').'.'.$request->picture_visit->extension();
                ##simpan gambar di folder public/images
                $request->picture_visit->move(storage_path('app/public/'),$imageName);
                ##simpan ke database
                $visit = Visit::create([
                    'tanggal_visit' => date('Y-m-d'),
                    'user_id' => Auth::user()->id,
                    'outlet_id' => $outletId,
                    'tipe_visit' => $request->tipe_visit,
                    'latlong_in' => $request->latlong_in,
                    'check_in_time' => Carbon::now(),
                    'picture_visit_in' => $imageName,
                ]);
                ##API berhasil
                return ResponseFormatter::success([
                    'visit' => $visit
                ],'berhasil check in');

            }

            if($checkOut)
            {


                $lastDataVisit = Visit::whereDate('tanggal_visit',date('Y-m-d'))->where('user_id',Auth::user()->id)->latest()->first();
                if($lastDataVisit != null)
                {
                    #validasi data
                    $request->validate([
                        'latlong_out' => ['required'],
                        'laporan_visit' =>['required'],
                        'picture_visit' => ['required','mimes:jpg,jpeg,png'],
                        'transaksi' => ['required'],

                ]);
                    $timeStart = new DateTime();
                    $TimeEnd = new DateTime();
                    $start = $lastDataVisit->check_in_time;
                    $end = time()*1000;
                    $timeStart->setTimestamp($start/1000);
                    $TimeEnd->setTimestamp($end/1000);

                    $awal = Carbon::parse($timeStart);
                    $akhir = Carbon::parse($TimeEnd);



                    $durasi = $awal->diffInMinutes($akhir,true);

                    ##buat nama gambar
                    $imageName = Carbon::parse(time())->getPreciseTimestamp(3).'-'.Auth::user()->username.'-'.'OUT-'.date('Y-m-d').'.'.$request->picture_visit->extension();

                    ##simpan gambar di folder public/images
                    $request->picture_visit->move(storage_path('app/public/'),$imageName);
                    $data = [
                        'latlong_out' => $request->latlong_out,
                        'check_out_time' => Carbon::now(),
                        'laporan_visit' => $request->laporan_visit,
                        'durasi_visit' => $durasi,
                        'picture_visit_out' => $imageName,
                        'transaksi' => $request->transaksi,
                    ];
                    $lastDataVisit->update($data);
                    return ResponseFormatter::success([
                        'visit' => $data
                    ],'berhasil check out');
                }
            }

        } catch (Exception $error) {
            return ResponseFormatter::error([
                'error' => $error
            ],'error',500);
        }
    }
}
