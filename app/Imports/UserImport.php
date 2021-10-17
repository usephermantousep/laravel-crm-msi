<?php

namespace App\Imports;

use App\Models\Role;
use App\Models\User;
use App\Models\Region;
use App\Models\Cluster;
use App\Models\Division;
use App\Models\BadanUsaha;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $user = new User();
        $user = $user->where('username', strtolower($row['username']));
        if ($user->first())
        {
            $user->update([
                'nama_lengkap' => strtoupper($row['nama_lengkap']),
                'username' => strtolower($row['username']),
                'role_id' => Role::where('name', preg_replace('/\s+/', '', $row['role']))->first()->id,
                'badanusaha_id' => BadanUsaha::where('name', preg_replace('/\s+/', '', $row['badan_usaha']))->first()->id,
                'divisi_id' => Division::where('name', preg_replace('/\s+/', '', $row['divisi']))->first()->id,
                'region_id' => Region::where('name', preg_replace('/\s+/', '', $row['region']))->first()->id,
                'cluster_id' => Cluster::where('name', preg_replace('/\s+/', '', $row['cluster']))->first()->id,
            ]);
        }
        else
        {
            return new User([
                'nama_lengkap' => strtoupper($row['nama_lengkap']),
                'username' => strtolower($row['username']),
                'role_id' => Role::where('name', preg_replace('/\s+/', '', $row['role']))->first()->id,
                'badanusaha_id' => BadanUsaha::where('name', preg_replace('/\s+/', '', $row['badan_usaha']))->first()->id,
                'divisi_id' => Division::where('name', preg_replace('/\s+/', '', $row['divisi']))->first()->id,
                'region_id' => Region::where('name', preg_replace('/\s+/', '', $row['region']))->first()->id,
                'cluster_id' => Cluster::where('name', preg_replace('/\s+/', '', $row['cluster']))->first()->id,
                'password' => bcrypt($row['password']),
            ]);
        }
        
    }
}
