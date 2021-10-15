<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TemplateOutletExport implements WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    // public function collection()
    // {
    //     return new Collection([
    //         [
    //             'PT.MSI (tanpa spasi)',
    //             'MSIS (tanpa spasi)',
    //             'SWJ (tanpa spasi)',
    //             'CW1 (tanpa spasi)',
    //             'BPXXXX (tanpa spasi)',
    //             'OUTLET CONTOH',
    //             'ALAMAT CONTOH',
    //             'CIREBON',
    //             '(HANYA BOLEH DI ISI MAINTAIN, UNMAINTAIN DAN UNPRODUCTIVE)',
    //             'XX (ANGKA)',
    //             'XXX.XXX.XXX (ANGKA)',
    //             '-XXX.XXXXXXX,XX.XXXXX (ANGKA TANPA SPASI)',
    //             'PEMILIK OUTLET CONTOH',
    //             '089123456789',
    //         ],
    //     ]);
    // }

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
        ];
    }
}
