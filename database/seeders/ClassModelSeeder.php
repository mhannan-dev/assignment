<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClassModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('class_models')->delete();
        $record = [
            [
                'title' => 'Five'
            ],
            [
                'title' => 'Four'
            ]
        ];
        DB::table('class_models')->insert($record);
    }
}
