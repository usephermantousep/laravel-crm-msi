<?php

namespace Database\Seeders;

use App\Models\Cluster;
use Illuminate\Database\Seeder;

class ClusterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cluster::insert([
            [
            'name' => 'CW1',
            'region' => 'WJS',
            ],
            [
            'name' => 'CW2',
            'region' => 'WJS',
            ],
            [
            'name' => 'CW3',
            'region' => 'WJS',
            ],
            [
            'name' => 'CW4',
            'region' => 'WJS',
            ],
            [
            'name' => 'CW5',
            'region' => 'WJS',
            ],
            [
            'name' => 'CW6',
            'region' => 'WJS',
            ],
            [
            'name' => 'CW7',
            'region' => 'WJU',
            ],
            [
            'name' => 'CW8',
            'region' => 'WJU',
            ],
            [
            'name' => 'CW9',
            'region' => 'WJU',
            ],
            [
            'name' => 'CW10',
            'region' => 'WJU',
            ],
            [
            'name' => 'CJ1',
            'region' => 'CJU',
            ],
            [
            'name' => 'CJ2',
            'region' => 'CJU',
            ],
            [
            'name' => 'CJ3',
            'region' => 'CJU',
            ],
            [
            'name' => 'CJ4',
            'region' => 'CJU',
            ],
            [
            'name' => 'CJ5',
            'region' => 'CJU',
            ],
            [
            'name' => 'CJ6',
            'region' => 'CJS',
            ],
            [
            'name' => 'CJ7',
            'region' => 'CJS',
            ],
            [
            'name' => 'CJ8',
            'region' => 'CJS',
            ],
            [
            'name' => 'CJ9',
            'region' => 'CJS',
            ],
            [
            'name' => 'CJ10',
            'region' => 'CJS',
            ],
            [
            'name' => 'JABO',
            'region' => 'JABO',
            ],
        ]);
    }
}
