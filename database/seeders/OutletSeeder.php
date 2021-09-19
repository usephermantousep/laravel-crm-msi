<?php

namespace Database\Seeders;

use App\Models\Outlet;
use Illuminate\Database\Seeder;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Outlet::insert([
            [
            'user_id' => 1,
            'nama_outlet' => "TOKO TUPAREV",
            'alamat_outlet' => "JL. TUPAREV NO 109F",
            'nama_pemilik_outlet' => "YUKE TUPAREV",
            'nomer_tlp_outlet' => '02318332833',
            'region' => 'WJ',
            'cluster_id'=> 1,
            'radius' => 50,
            'latlong' => '-6.7108306020177455,108.53886410485876',
            'status_outlet' => 'MAINTAIN',
        ],
        [
            'user_id' => 1,
            'nama_outlet' => "TOKO PETRATEAN",
            'alamat_outlet' => "JL. PETRATEAN NO 109F",
            'nama_pemilik_outlet' => "YUKE PETRATEAN",
            'nomer_tlp_outlet' => '02318332833',
            'region' => 'WJ',
            'cluster_id'=> 1,
            'radius' => 50,
            'latlong' => '-6.721455799999999,108.5637634',
            'status_outlet' => 'MAINTAIN',
        ],
        [
            'user_id' => 1,
            'nama_outlet' => "TOKO PERUM",
            'alamat_outlet' => "JL. PERUM NO 109F",
            'nama_pemilik_outlet' => "YUKE PERUM",
            'nomer_tlp_outlet' => '02318332833',
            'region' => 'WJ',
            'cluster_id'=> 1,
            'radius' => 50,
            'latlong' => '-6.748829354494562, 108.56074800552257',
            'status_outlet' => 'MAINTAIN',
        ],
        [
            'user_id' => 1,
            'nama_outlet' => "TOKO RUMAH",
            'alamat_outlet' => "JL. PERUM NO 109F",
            'nama_pemilik_outlet' => "YUKE PERUM",
            'nomer_tlp_outlet' => '02318332833',
            'region' => 'WJ',
            'cluster_id'=> 1,
            'radius' => 50,
            'latlong' => '-6.696488,108.507180',
            'status_outlet' => 'MAINTAIN',
        ],
    ],
    );
    }
}
