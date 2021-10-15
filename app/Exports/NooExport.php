<?php

namespace App\Exports;

use App\Models\Noo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NooExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Noo::with(['cluster','region','badanusaha'])->get();
    }

    public function headings(): array
    {
        return [
            'tanggal dibuat',
            'dibuat oleh',
            'kode outlet',
            'badan usaha',
            'nama outlet',
            'nama pemilik',
            'nomer KTP/NPWP',
            'alamat',
            'kota',
            'nomer outlet',
            'region',
            'cluster',
            'limit',
            'status',
            'tanggal disetujui',
            'disetujui oleh',
            'tanggal ditolak',
            'ditolak oleh',
            'keterangan',
        ];
    }

    public function map($noo) : array 
    {
        return [
            date('d M Y',$noo->created_at/1000),
            $noo->created_by,
            $noo->kode_outlet ?? '-',
            $noo->badanusaha->name,
            $noo->nama_outlet,
            $noo->nama_pemilik_outlet,
            $noo->ktp_outlet,
            $noo->alamat_outlet,
            $noo->kota,
            $noo->nomer_tlp_outlet,
            $noo->region->name,
            $noo->cluster->name,
            'Rp '.number_format($noo->limit,0,',','.'),
            $noo->status,
            $noo->approved_at == null ? '-' : date('d M Y',$noo->created_at/1000),
            $noo->approved_by ?? '-',
            $noo->rejected_at == null ? '-' : date('d M Y',$noo->created_at/1000),
            $noo->rejected_by ?? '-',
            $noo->keterangan ?? '-'
        ];
    }
}
