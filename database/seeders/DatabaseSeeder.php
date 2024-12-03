<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\City;
use App\Models\Branch;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        //User::factory()->create([
        //    'name' => 'Test User',
        //    'email' => 'test@example.com',
        //]);
        City::create([
            'id' => 1,
            'name' => 'الرياض',
        ]);
        City::create([
            'id' => 2,
            'name' => 'القصيم',
        ]);

        Branch::create([
            'name' => "الفرع شمالي",
            'description' => "شارع انس بن مالك, حي الياسمين, شمال مدينة الرياض",
            'image' => '/branches-images/1.png',
            'city_id' => 1,
        ]);
        Branch::create([
            'name' => "الفرع الجنوبي",
            'description' => "شارع الامام علي ابن ابي طالب, حي الفيصلية, جنوب مدينة الرياض",
            'image' => '/branches-images/2.png',
            'city_id' => 1,
        ]);
        Branch::create([
            'name' => "فرع بريدة",
            'description' => "شارع عمر بن الخطاب, حي الرحاب, شمال مدينة بريدة",
            'image' => '/branches-images/3.png',
            'city_id' => 2,
        ]);



    }
}
