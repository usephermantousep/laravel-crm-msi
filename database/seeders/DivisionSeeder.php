<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Division::insert([
            [
                'name' => 'MSIS',
            ],
            [
                'name' => 'ORAIMO',
            ],
            [
                'name' => 'TECNO',
            ],
            [
                'name' => 'REALME',
            ],
            [
                'name' => '-',
            ],
            [
                'name' => 'ALL',
            ],
        ]);
    }
}
