<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Region::insert(
        [
            [
                'name' =>'SWJ'
            ],
            [
                'name' =>'NWJ'
            ],
            [
                'name' =>'SCJ'
            ],
            [
                'name' =>'NCJ'
            ],
            [
                'name' =>'SEJ'
            ],
            [
                'name' =>'NEJ'
            ],
            [
                'name' =>'JABO'
            ],
            [
                'name' => '-',
            ],
        ]
    );
    }
}
