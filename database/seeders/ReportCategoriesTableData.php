<?php

namespace Database\Seeders;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ReportCategoriesTableData extends Seeder
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
            'category_name' => 'Sexual Harassment',
            'weight' => 5,
            'created_at' => $now,
            'updated_at' => $now,
        ],

        [
            'category_name' => 'Physical Abuse',
            'weight' => 4,
            'created_at' => $now,
            'updated_at' => $now,
        ],

        [
            'category_name' => 'Bullying',
            'weight' => 4,
            'created_at' => $now,
            'updated_at' => $now,
        ],

        [
            'category_name' => 'Hate Comment',
            'weight' => 3,
            'created_at' => $now,
            'updated_at' => $now,
        ],

        [
            'category_name' => 'Fraud',
            'weight' => 4,
            'created_at' => $now,
            'updated_at' => $now,
        ],

        [
            'category_name' => 'Building abd Facility',
            'weight' => 2,
            'created_at' => $now,
            'updated_at' => $now,
        ],

        [
            'category_name' => 'Food & Beverages',
            'weight' => 2,
            'created_at' => $now,
            'updated_at' => $now,
        ],

        [
            'category_name' => 'Teaching Staff',
            'weight' => 2,
            'created_at' => $now,
            'updated_at' => $now,
        ],

        [
            'category_name' => 'Staff',
            'weight' => 2,
            'created_at' => $now,
            'updated_at' => $now,
        ]

     ];

        DB::table('report_categories')->insert($data);
    }
}
