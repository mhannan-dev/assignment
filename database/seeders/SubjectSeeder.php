<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subjects')->delete();
        $record = [
            [
                'title' => 'Math'
            ],
            [
                'title' => 'Bengali Literature'
            ]
        ];
        DB::table('subjects')->insert($record);
    }
}
