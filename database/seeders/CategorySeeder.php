<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = [
            ['name' => 'Teknologi',
        'user_id' => 1],
            ['name' => 'Ekonomi','user_id' => 1],
        ];

        DB::table('categories')->insert($category);
    }
}
