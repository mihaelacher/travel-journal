<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FileTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('file_types')->insert([
            'id' => 1,
            'name' => 'Video',
            'slug' => 'file_types.video',
        ]);

        DB::table('file_types')->insert([
            'id' => 2,
            'name' => 'Image',
            'slug' => 'file_types.image',
        ]);
    }
}
