<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\DBAL\TimestampType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportTableData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $data = [
        [    
            'user_id' => 5,
            'category_id' => 2,
            'evidence' => 'testsss',
            'title' => 'huahu',
            'created_at' => $now,
            'updated_at' => $now,
        ],
    
        [
            'user_id' => 2,
            'category_id' => 6,
            'evidence' => 'test5',
            'title' => 'Shandez Laper',
            'created_at' => $now,
            'updated_at' => $now,
        ],

        [
            'user_id' => 2,
            'category_id' => 7,
            'evidence' => 'test7',
            'title' => 'Shandez Gigit orang',
            'created_at' => $now,
            'updated_at' => $now,
        ]
        ];

        DB::table('reports')->insert($data);

    }
}
