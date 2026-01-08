<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // public function run(): void
    // {
    //     //
    // }
    public function run()
    {
        DB::table('faculties')->insert([
            [
                'code' => 'science',
                'name' => 'Faculty of Science',
                'language' => 'en',
            ],
            [
                'code' => 'engineering',
                'name' => 'Faculty of Engineering',
                'language' => 'en',
            ],
            [
                'code' => 'medicine',
                'name' => 'Faculty of Medicine',
                'language' => 'en',
            ],
        ]);
    }


}
