<?php

namespace App\Exports;

use App\Models\Outlet;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OutletExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Outlet::with(['cluster', 'region', 'badanusaha'])->whereIn('divisi_id',[2,4])
            ->orderBy('nama_outlet')->get();
    }

    public function headings(): array
    {
        return [
            'badan_usaha',
            'divisi',
            'region',
            'cluster',
            'kode_outlet',
            'nama_outlet',
            'alamat_outlet',
            'distric',
            'status',
            'radius',
            'limit',
            'latlong',
            'nama_pemilik_outlet',
            'telepon_outlet',
            'TM',
            'ASC',
            'DSF',
            'tanggal regitrasi',
        ];
    }

    public function map($outlet): array
    {
        return [
            $outlet->badanusaha->name,
            $outlet->divisi->name,
            $outlet->region->name,
            $outlet->cluster->name,
            $outlet->kode_outlet,
            $outlet->nama_outlet,
            $outlet->alamat_outlet,
            $outlet->distric,
            $outlet->status_outlet,
            $outlet->radius . ' Meter',
            'Rp ' . number_format($outlet->limit, 0, ',', '.'),
            $outlet->latlong,
            $outlet->nama_pemilik_outlet,
            $outlet->nomer_tlp_outlet,
            User::where('divisi_id', $outlet->divisi_id)->where('region_id', $outlet->region_id)->where('role_id', 2)->first()->tm->nama_lengkap  ?? 'VACANT',
            User::where('divisi_id', $outlet->divisi_id)->where('region_id', $outlet->region_id)->where('role_id', 2)->first()->nama_lengkap ?? 'VACANT',
            User::where('divisi_id', $outlet->divisi_id)->where('region_id', $outlet->region_id)->where('cluster_id', $outlet->cluster_id)->where('role_id', 3)->first()->nama_lengkap ?? 'VACANT',
            date('d M Y', $outlet->created_at / 1000),
        ];
    }
}
