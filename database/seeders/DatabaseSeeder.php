<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Hobby;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Hobby::insert([
            [
                "hobby" => 'programming',
            ],
            [
                "hobby" => 'games',
            ],
            [
                "hobby" => 'reading',
            ],
            [
                "hobby" => 'photography',
            ],
        ]);

        Category::insert([
            [
                "category" => 'category A',
            ],
            [
                "category" => 'category B',
            ],
            [
                "category" => 'category C',
            ],
            [
                "category" => 'category D',
            ],
        ]);
    }
}
