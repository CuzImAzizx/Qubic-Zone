<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\User;
use App\Models\City;
use App\Models\Branch;
use App\Models\Size;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        User::create([
            'name' => "user",
            'email' => 'user@email.com',
            'password' => Hash::make('123456789'), 
        ]);

        //Create cities
        City::create([
            'id' => 1,
            'name' => 'الرياض',
        ]);
        City::create([
            'id' => 2,
            'name' => 'القصيم',
        ]);
        
        //Create branches
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

        //Create sizes
        Size::create([
            'name' => 'صغير',
            'dimensions' => '5x5"',
            'description' => 'مناسب لـ أغراض صغيرة، وثائق، حقائب صغيرة',
            'image' => '/assets/images/unit-sizes/small.png',
            'price_per_month' => 150,
        ]);
        Size::create([
            'name' => 'متوسط',
            'dimensions' => '10x15"',
            'description' => 'مناسب لـ: أثاث صغير، دراجات، معدات رياضية',
            'image' => '/assets/images/unit-sizes/medium.png',
            'price_per_month' => 300,
        ]);
        Size::create([
            'name' => 'كبير',
            'dimensions' => '10x30"',
            'description' => 'مناسب لـ: أثاث متوسط الحجم، أجهزة منزلية، أرشيف',
            'image' => '/assets/images/unit-sizes/large.png',
            'price_per_month' => 450,
        ]);


        // Create the units on all the branches
        $branches = Branch::all();
        foreach ($branches as $branch) {
            
        // Create 20 small normal units for $branch->id,
        for ($i=0; $i < 20; $i++) { 
            Unit::create([
                'branch_id' => $branch->id,
                'size_id' => 1,
                'type' => 'normal',
                'is_available' => true,
            ]);
        }
        // Create 10 medium normal units for branch_id 1
        for ($i=0; $i < 10; $i++) { 
            Unit::create([
                'branch_id' => $branch->id,
                'size_id' => 2,
                'type' => 'normal',
                'is_available' => true,
            ]);
        }
        // Create 5 large normal units for branch_id 1
        for ($i=0; $i < 5; $i++) { 
            Unit::create([
                'branch_id' => $branch->id,
                'size_id' => 3,
                'type' => 'normal',
                'is_available' => true,
            ]);
        }
        // Create 5 small refrigerated units for branch_id 1
        for ($i=0; $i < 5; $i++) { 
            Unit::create([
                'branch_id' => $branch->id,
                'size_id' => 1,
                'type' => 'refrigerated',
                'is_available' => true,
            ]);
        }

        }


        





    }
}
