<?php

namespace App\Imports;

use App\Models\BadanUsaha;
use App\Models\Cluster;
use App\Models\Division;
use App\Models\Outlet;
use App\Models\Region;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OutletImport implements ToModel,WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */


    public function model(array $row)
    {
        $outlet = new Outlet();
        $outlet = $outlet->where('kode_outlet', $row['kode_outlet']);
        if ($outlet->first())
        {
            $outlet->update([
                'badanusaha_id' => BadanUsaha::where('name', preg_replace('/\s+/', '', $row['badan_usaha']))->first()->id,
                'divisi_id' => Division::where('name', preg_replace('/\s+/', '', $row['divisi']))->first()->id,
                'region_id' => Region::where('name', preg_replace('/\s+/', '', $row['region']))->first()->id,
                'cluster_id' => Cluster::where('name', preg_replace('/\s+/', '', $row['cluster']))->first()->id,
                'kode_outlet' => strtoupper($row['kode_outlet']),
                'nama_outlet' => strtoupper($row['nama_outlet']),
                'alamat_outlet' => strtoupper($row['alamat_outlet']),
                'distric' => strtoupper($row['distric']),
                'status_outlet' => strtoupper($row['status']),
                'radius' => $row['radius'] ?? 0,
                'limit' => $row['limit'] ?? 0,
                'latlong' => $row['latlong'],
                'nama_pemilik_outlet' => $row['nama_pemilik_outlet'] ? strtoupper($row['nama_pemilik_outlet']) : null,
                'nomer_tlp_outlet' => $row['telepon_outlet'] ? strtoupper($row['telepon_outlet']) : null,
            ]);
        }
        else
        {
            return new Outlet([
                'badanusaha_id' => BadanUsaha::where('name', preg_replace('/\s+/', '', $row['badan_usaha']))->first()->id,
                'divisi_id' => Division::where('name', preg_replace('/\s+/', '', $row['divisi']))->first()->id,
                'region_id' => Region::where('name', preg_replace('/\s+/', '', $row['region']))->first()->id,
                'cluster_id' => Cluster::where('name', preg_replace('/\s+/', '', $row['cluster']))->first()->id,
                'kode_outlet' => strtoupper($row['kode_outlet']),
                'nama_outlet' => strtoupper($row['nama_outlet']),
                'alamat_outlet' => strtoupper($row['alamat_outlet']),
                'distric' => strtoupper($row['distric']),
                'status_outlet' => strtoupper($row['status']),
                'radius' => $row['radius'] ?? 0,
                'limit' => $row['limit'] ?? 0,
                'latlong' => $row['latlong'],
                'nama_pemilik_outlet' => $row['nama_pemilik_outlet'] ? strtoupper($row['nama_pemilik_outlet']) : null,
                'nomer_tlp_outlet' => $row['telepon_outlet'] ? strtoupper($row['telepon_outlet']) : null,
            ]);
        }
        
    }
}
