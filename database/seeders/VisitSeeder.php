<?php

namespace Database\Seeders;

use App\Models\Visit;
use Illuminate\Database\Seeder;

class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Visit::insert([
            [
                'tanggal_visit'=> '2021-09-04',
                'user_id' => 1,
                'outlet_id' => 1,
                'tipe_visit' => 'PLANNED',
                'latlong_in' => '-6.7108306020177455,108.53886410485876',
                'latlong_out' => '-6.7108306020177455,108.53886410485876',
                'check_in_time' => '2021-08-24 08:10',
                'check_out_time' => '2021-08-24 09:00',
                'durasi_visit' => 50,
                'laporan_visit' => 'ini itu anu dan gini',
                'picture_visit_in' => 'https://i.im.ge/2021/07/28/IDr9C.jpg',
                'picture_visit_out' => 'https://i.im.ge/2021/07/28/IDr9C.jpg',
                'created_at' => '2021-09-04 08:10'
            ],
            [
                'tanggal_visit'=> '2021-09-04',
                'user_id' => 1,
                'outlet_id' => 2,
                'tipe_visit' => 'PLANNED',
                'latlong_in' => '-6.7108306020177455,108.53886410485876',
                'latlong_out' => null,
                'check_in_time' => '2021-08-24 09:10',
                'check_out_time' => null,
                'durasi_visit' => null,
                'laporan_visit' => null,
                'picture_visit_in' => 'https://i.im.ge/2021/07/28/IDr9C.jpg',
                'picture_visit_out' => null,
                'created_at' => '2021-09-04 09:10'

            ],
        ]);
    }
}
