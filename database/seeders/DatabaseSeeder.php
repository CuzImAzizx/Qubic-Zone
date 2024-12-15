<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\User;
use App\Models\City;
use App\Models\Branch;
use App\Models\Plan;
use App\Models\Size;
use App\Models\Subscription;
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

        //Create plans
        $basicPlan = Plan::create([
            'name' => 'الخطة الأساسية',
            'description' => '
                <p>الوصول الى خصائص اساسية</p>
                <p><strong>:الباقة العادية</strong></p>
                <div class="right-aligned-list">
                    <ul>
                        <li>الدعم الفني أوقات الدوام</li>
                        <li>إمكانية طلب التنظيف ٢/٣ مرة بالأسبوع</li>
                        <li>استخراج بدل فاقد لبطاقات الدخول مرة واحدة شهريًا</li>
                    </ul>
                </div>',
            'image' => 'assets/images/plans/planBasic.png',
            'price_per_month' => 0,
        ]);
        $premiumPlan = Plan::create([
            'name' => 'الخطة الذهبية',
            'description' => '
                <p>الوصول الى خصائص أكثر</p>
                <p><strong>:الباقة المميزة</strong></p>
                <div class="right-aligned-list">
                    <ul>
                        <li>دعم فني على مدار الساعة</li>
                        <li>امكانية حجز المستودع لمدة تصل الى سنتين</li>
                        <li>خزانة شخصية</li>
                        <li>إتاحة خدمة التنظيف يوميًا</li>
                        <li>استخراج بدل فاقد لبطاقات ٣ مرات شهريًا</li>
                    </ul>
                </div>',
            'image' => 'assets/images/plans/planPremium.png',
            'price_per_month' => 200,
        ]);

        $defaultUser = User::create([
            'name' => "user",
            'email' => 'user@email.com',
            'password' => Hash::make('123456789'),
        ]);

        Subscription::create([
            'user_id' => $defaultUser->id,
            'plan_id' => $basicPlan->id,
            'start_date' => now(),
            'end_date' => null,
            'loyalty_points' => 0,
        ]);

        //Create cities
        $riyadCity = City::create([
            'name' => 'الرياض',
        ]);
        $qassimCity = City::create([
            'name' => 'القصيم',
        ]);
        $colifornia = City::create([
            'name' => 'كلفورنيا',
        ]);

        //Create branches
        Branch::create([
            'name' => "الفرع شمالي",
            'description' => "شارع انس بن مالك, حي الياسمين, شمال مدينة الرياض",
            'image' => '/assets/images/warehouses/1.png',
            'city_id' => $riyadCity->id,
        ]);
        Branch::create([
            'name' => "الفرع الجنوبي",
            'description' => "شارع الامام علي ابن ابي طالب, حي الفيصلية, جنوب مدينة الرياض",
            'image' => '/assets/images/warehouses/2.png',
            'city_id' => $riyadCity->id,
        ]);
        Branch::create([
            'name' => "فرع بريدة",
            'description' => "شارع عمر بن الخطاب, حي الرحاب, شمال مدينة بريدة",
            'image' => '/assets/images/warehouses/3.png',
            'city_id' => $qassimCity->id,
        ]);
        Branch::create([
            'name' => "فرع لوس انجلوس",
            'description' => "شارع غارفيلد آيف, غرب وادي سان غابرييل, لوس انجلوس, جنوب كلفورنيا",
            'image' => '/assets/images/warehouses/5.png',
            'city_id' => $colifornia->id,
        ]);

        //Create sizes
        $smallSize = Size::create([
            'name' => 'صغير',
            'dimensions' => '5x5"',
            'description' => 'مناسب لـ أغراض صغيرة، وثائق، حقائب صغيرة',
            'image' => '/assets/images/unit-sizes/small.png',
            'price_per_month' => 150,
        ]);
        $mediumSize = Size::create([
            'name' => 'متوسط',
            'dimensions' => '10x15"',
            'description' => 'مناسب لـ: أثاث صغير، دراجات، معدات رياضية',
            'image' => '/assets/images/unit-sizes/medium.png',
            'price_per_month' => 300,
        ]);
        $largeSize = Size::create([
            'name' => 'كبير',
            'dimensions' => '10x30"',
            'description' => 'مناسب لـ: أثاث متوسط الحجم، أجهزة منزلية، أرشيف',
            'image' => '/assets/images/unit-sizes/large.png',
            'price_per_month' => 450,
        ]);

        // Create the units on all the branches
        $branches = Branch::all();
        foreach ($branches as $branch) {

            // Create 20 small normal units for $branch->id
            for ($i = 0; $i < 20; $i++) {
                Unit::create([
                    'branch_id' => $branch->id,
                    'size_id' => $smallSize->id,
                    'type' => 'normal',
                    'is_available' => true,
                ]);
            }
            // Create 10 medium normal units for $branch->id
            for ($i = 0; $i < 10; $i++) {
                Unit::create([
                    'branch_id' => $branch->id,
                    'size_id' => $mediumSize->id,
                    'type' => 'normal',
                    'is_available' => true,
                ]);
            }
            // Create 5 large normal units for $branch->id
            for ($i = 0; $i < 5; $i++) {
                Unit::create([
                    'branch_id' => $branch->id,
                    'size_id' => $largeSize->id,
                    'type' => 'normal',
                    'is_available' => true,
                ]);
            }
            // Create 5 small refrigerated units for $branch->id
            for ($i = 0; $i < 5; $i++) {
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
