<?php

namespace App\Exports;

use App\Models\Outlet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OutletExport implements FromCollection,WithMapping,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Outlet::with('cluster')->get();
    }

    public function headings(): array
    {
        return [
            'nama',
            'alamat',
            'pemilik',
            'telepon',
            'region',
            'cluster',
            'radius',
            'latlong',
            'status',

        ];
    }

    public function map($outlet) : array 
    {
        return [
            $outlet->nama_outlet,
            $outlet->alamat_outlet,
            $outlet->nama_pemilik_outlet,
            $outlet->nomer_tlp_outlet,
            $outlet->region,
            $outlet->cluster->name,
            $outlet->radius.' Meter',
            $outlet->latlong,
            $outlet->status_outlet,
        ];
 
 
    }
}
