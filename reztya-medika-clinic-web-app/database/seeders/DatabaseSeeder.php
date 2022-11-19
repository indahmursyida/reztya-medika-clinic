<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Order;
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
        DB::table('user_role')->insert([
            'user_role_name' => 'Admin'
        ]);

        DB::table('user_role')->insert([
            'user_role_name' => 'Member'
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

        DB::table('users')->insert([
            'user_role_id' => 2,
            'username' => 'Testing1',
            'name' => 'Testing1 Testing1 Testing1',
            'birthdate' => '2001-06-18',
            'phone' => '081285879816',
            'address' => 'Jalan KH Iskandar Muda',
            'email' => 'testing1@gmail.com',
            'password' => bcrypt('testing1'),
            'profile_picture' => 'profile-images/profile_picture_default.jpg',
            'is_banned' => false
        ]);

        DB::table('users')->insert([
            'user_role_id' => 3,
            'username' => 'Testing2',
            'name' => 'Testing2 Testing2 Testing2',
            'birthdate' => '2001-06-18',
            'phone' => '081285879816',
            'address' => 'Jalan KH Iskandar Tua',
            'email' => 'testing2@gmail.com',
            'password' => bcrypt('testing2'),
            'profile_picture' => 'profile-images/profile_picture_default.jpg',
            'is_banned' => true
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

        Order::create([
            'user_id' => 2,
            'order_date' => Carbon::create('2022', '05', '23'),
            'status' => 'UNPAID'
        ]);

        OrderDetail::create([
            'order_detail_id' => 1,
            'order_id' => 1,
            'service_id' => 1,
            'schedule_id' => 2,
            'quantity' => 1
        ]);

        OrderDetail::create([
            'order_detail_id' => 2,
            'order_id' => 1,
            'service_id' => 2,
            'schedule_id' => 3,
            'quantity' => 1
        ]);

        OrderDetail::create([
            'order_detail_id' => 3,
            'order_id' => 1,
            'product_id' => 1,
            'quantity' => 2
        ]);

        OrderDetail::create([
            'order_detail_id' => 4,
            'order_id' => 1,
            'product_id' => 2,
            'quantity' => 3
        ]);
    }
}
