<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sections')->delete();
        $record = [
            [
                'title' => 'Section one'
            ],
            [
                'title' => 'Section two'
            ]
        ];
        DB::table('sections')->insert($record);
    }
}
