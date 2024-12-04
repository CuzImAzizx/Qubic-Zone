<?php

namespace Database\Seeders;

use App\Models\Unit;
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
            'image' => '/assets/images/warehouses/1.png',
            'city_id' => 1,
        ]);
        Branch::create([
            'name' => "الفرع الجنوبي",
            'description' => "شارع الامام علي ابن ابي طالب, حي الفيصلية, جنوب مدينة الرياض",
            'image' => '/assets/images/warehouses/2.png',
            'city_id' => 1,
        ]);
        Branch::create([
            'name' => "فرع بريدة",
            'description' => "شارع عمر بن الخطاب, حي الرحاب, شمال مدينة بريدة",
            'image' => '/assets/images/warehouses/3.png',
            'city_id' => 2,
        ]);
        // Create 20 small units for branch_id 1
        for ($i=0; $i < 20; $i++) { 
            Unit::create([
                'size_name' => 'صغير',
                'size_inch' => '5x5"',
                'description' => 'مناسب لـ أغراض صغيرة، وثائق، حقائب صغيرة',
                'image' => '/assets/images/unit-sizes/small.png',
                'price_per_month' => 150,
                'isAvailable' => true,
                'branch_id' => 1,
            ]);
        }
        // Create 10 medium units for branch_id 1
        for ($i=0; $i < 10; $i++) { 
            Unit::create([
                'size_name' => 'متوسط',
                'size_inch' => '10x15"',
                'description' => 'مناسب لـ: أثاث صغير، دراجات، معدات رياضية',
                'image' => '/assets/images/unit-sizes/medium.png',
                'price_per_month' => 300,
                'isAvailable' => true,
                'branch_id' => 1,
            ]);
        }
        // Create 5 large units for branch_id 1
        for ($i=0; $i < 5; $i++) { 
            Unit::create([
                'size_name' => 'كبير',
                'size_inch' => '10x30"',
                'description' => 'مناسب لـ: أثاث متوسط الحجم، أجهزة منزلية، أرشيف',
                'image' => '/assets/images/unit-sizes/large.png',
                'price_per_month' => 450,
                'isAvailable' => true,
                'branch_id' => 1,
            ]);
        }





    }
}
