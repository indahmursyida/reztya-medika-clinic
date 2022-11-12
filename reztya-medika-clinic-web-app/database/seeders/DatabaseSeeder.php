<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Schedule;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'category_name' => 'Body Care'
        ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('user_role')->insert([
            'user_role_name' => 'Admin'
        ]);

        DB::table('user_role')->insert([
            'user_role_name' => 'Guest'
        ]);

        DB::table('users')->insert([
            'user_role_id' => 1,
            'username' => 'Admin',
            'name' => 'Admin Admin Admin',
            'birthdate' => '2001-06-18',
            'phone' => '081285879816',
            'address' => 'Your Heart my Darling',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'profile_picture' => 'profile-images/profile_picture_default.jpg',
            'is_banned' => false
        ]);

        Category::create([
            'category_name' => 'Body Care'
        ]);

        Category::create([
            'category_name' => 'Skincare'
        ]);

        Product::create([
            'name' => 'Body Shower',
            'category_id' => '1',
            'description' => "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit dolor dolores laudantium ipsa earum non et accusantium sint voluptate error necessitatibus accusamus laboriosam impedit est, maxime tempora perferendis sunt quia.",
            'size' => '150 ml',
            'price' => '150000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/bodyshower.jpg'
        ]);
        Product::create([
            'name' => 'Moisturizer',
            'category_id' => '2',
            'description' => "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit dolor dolores laudantium ipsa earum non et accusantium sint voluptate error necessitatibus accusamus laboriosam impedit est, maxime tempora perferendis sunt quia.",
            'size' => '100 ml',
            'price' => '950000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/moisturizer.jpg'
        ]);

        Service::create([
            'name' => 'Totok Wajah',
            'category_id' => '2',
            'description' => "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit dolor dolores laudantium ipsa earum non et accusantium sint voluptate error necessitatibus accusamus laboriosam impedit est, maxime tempora perferendis sunt quia.",
            'duration' => '20',
            'price' => '150000',
            'image_path' => '/service-images/totokwajah.jpeg'
        ]);

        Service::create([
            'name' => 'Masker Wajah',
            'category_id' => '2',
            'description' => "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit dolor dolores laudantium ipsa earum non et accusantium sint voluptate error necessitatibus accusamus laboriosam impedit est, maxime tempora perferendis sunt quia.",
            'duration' => '30',
            'price' => '120000',
            'image_path' => '/service-images/maskerwajah.jpeg'
        ]);
        Schedule::create([
            'start_time' => Carbon::createFromFormat('d-m-Y H:i:s', '01-11-2022 10:00:00'),
            'end_time' => Carbon::createFromFormat('d-m-Y H:i:s', '01-11-2022 11:00:00'),
            'status' => 'Booked'
        ]);

        Schedule::create([
            'start_time' => Carbon::createFromFormat('d-m-Y H:i:s', '02-11-2022 11:00:00'),
            'end_time' => Carbon::createFromFormat('d-m-Y H:i:s', '02-11-2022 12:00:00'),
            'status' => 'Canceled'
        ]);

        Schedule::create([
            'start_time' => Carbon::createFromFormat('d-m-Y H:i:s', '03-11-2022 13:00:00'),
            'end_time' => Carbon::createFromFormat('d-m-Y H:i:s', '03-11-2022 14:00:00'),
            'status' => 'Ready'
        ]);

        OrderDetail::create([
            'service_id' => 1,
            'schedule_id' => 1
        ]);

        OrderDetail::create([
            'product_id' => 1,
            'quantity' => 2
        ]);
    }
}
