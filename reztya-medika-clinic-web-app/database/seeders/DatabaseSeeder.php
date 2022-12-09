<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\Cart;
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
            'is_banned' => false,
            'email_verified_at' => now()
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
            'is_banned' => false,
            'email_verified_at' => now()
        ]);

        DB::table('users')->insert([
            'user_role_id' => 2,
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

        // Product::create([
        //     'name' => 'Body Shower',
        //     'category_id' => '1',
        //     'description' => "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit dolor dolores laudantium ipsa earum non et accusantium sint voluptate error necessitatibus accusamus laboriosam impedit est, maxime tempora perferendis sunt quia.",
        //     'size' => '150 ml',
        //     'price' => '150000',
        //     'expired_date' => Carbon::create('2024', '08', '23'),
        //     'stock' => '20',
        //     'image_path' => '/product-images/bodyshower.jpg'
        // ]);

        // Product::create([
        //     'name' => 'Moisturizer',
        //     'category_id' => '2',
        //     'description' => "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit dolor dolores laudantium ipsa earum non et accusantium sint voluptate error necessitatibus accusamus laboriosam impedit est, maxime tempora perferendis sunt quia.",
        //     'size' => '100 ml',
        //     'price' => '950000',
        //     'expired_date' => Carbon::create('2024', '08', '23'),
        //     'stock' => '20',
        //     'image_path' => '/product-images/moisturizer.jpg'
        // ]);

        Service::create([
            'name' => 'Bekam',
            'category_id' => '2',
            'description' => "BERAM SUNNAH & STERIL\n
            ㆍ Membuang sel-sel darah yang mati\n
            ㆍ Menstabilkan tekanan darah\n
            ㆍ Melancarkan peredaran darah\n
            ㆍ Mengeluarkan toksin dalam tubuh\n
            ㆍ Menghilangkan angin dalam badan\n
            ㆍ Mengurangi kolestrol dalam tubuh\n
            ㆍ Meringankan tubuh\n
            ㆍ Melegakan sakit kepala\n
            ㆍ Mengatasi kelelahan\n",
            'duration' => '30',
            'price' => '150000',
            'image_path' => '/service-images/bekam.jpg'
        ]);

        Service::create([
            'name' => 'Paket Pijat Stres Wajah dan Setrika Wajah',
            'category_id' => '2',
            'description' => "Manfaat Pijat Stres Wajah\n
            ㆍMencegah penuaan dini\n
            ㆍMelancarkan peredaran darah\n
            ㆍMerelaksasi otot wajah\n
            ㆍMenghilangkan stress\n
            ㆍMengatasi sinusitis\n
            ㆍMengecilkan pori-pori\n
            ㆍDetox kulit secara alami\n
            ㆍMembuat wajah lebih bercahaya\n\n
            ",
            'duration' => '60',
            'price' => '225000',
            'image_path' => '/service-images/totokwajah.jpeg'
        ]);

        Service::create([
            'name' => 'Paket Pijat Wajah, Lumi SPA, Setrika Wajah, Masker',
            'category_id' => '2',
            'description' => "Pijat Stres Wajah, Lumi SPA, Setrika Wajah, Masker",
            'duration' => '50',
            'price' => '325000',
            'image_path' => '/service-images/totokwajah.jpg'
        ]);

        Service::create([
            'name' => 'Paket Pijat Wajah dan Lumi SPA',
            'category_id' => '2',
            'description' => "Pijat Stres Wajah dan Lumi SPA",
            'duration' => '50',
            'price' => '175000',
            'image_path' => '/service-images/maskerwajah.jpeg'
        ]);

        Service::create([
            'name' => 'Paket Pijat Wajah dan Lumi SPA',
            'category_id' => '2',
            'description' => "Pijat Stres Wajah dan Lumi SPA",
            'duration' => '50',
            'price' => '275000',
            'image_path' => '/service-images/maskerwajah.jpeg'
        ]);

        Service::create([
            'name' => 'Paket Pijat Wajah, Lumi SPA, Setrika Wajah, Masker, Totok Inner Beauty',
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

        // Order::create([
        //     'user_id' => 2,
        //     'order_date' => Carbon::create('2022', '05', '23'),
        //     'status' => 'UNPAID'
        // ]);

        // OrderDetail::create([
        //     'order_detail_id' => 1,
        //     'order_id' => 1,
        //     'service_id' => 1,
        //     'schedule_id' => 2,
        //     'quantity' => 1
        // ]);

        // OrderDetail::create([
        //     'order_detail_id' => 2,
        //     'order_id' => 1,
        //     'service_id' => 2,
        //     'schedule_id' => 3,
        //     'quantity' => 1
        // ]);

        // OrderDetail::create([
        //     'order_detail_id' => 3,
        //     'order_id' => 1,
        //     'product_id' => 1,
        //     'quantity' => 2
        // ]);

        // OrderDetail::create([
        //     'order_detail_id' => 4,
        //     'order_id' => 1,
        //     'product_id' => 2,
        //     'quantity' => 3
        // ]);

        Cart::create([
            'user_id' => 2,
            'service_id' => 2,
            'schedule_id' => 2
        ]);

        Cart::create([
            'user_id' => 2,
            'service_id' => 1,
            'schedule_id' => 1
        ]);

        Cart::create([
            'user_id' => 2,
            'product_id' => 1,
            'quantity' => 1
        ]);

        Cart::create([
            'user_id' => 2,
            'product_id' => 2,
            'quantity' => 3
        ]);

        Product::create([
            'name' => 'Susu Almond (Small)',
            'category_id' => '1',
            'description' => "Deskripsi Susu Almond",
            'size' => '250 ml',
            'price' => '27000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/susualmond.jpg'
        ]);

        Product::create([
            'name' => 'Susu Almond (Medium)',
            'category_id' => '1',
            'description' => "Deskripsi Susu Almond",
            'size' => '500 ml',
            'price' => '50000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/susualmond.jpg'
        ]);

        Product::create([
            'name' => 'Susu Almond (Large)',
            'category_id' => '1',
            'description' => "Deskripsi Susu Almond",
            'size' => '1000 ml',
            'price' => '95000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/susualmond.jpg'
        ]);

        Product::create([
            'name' => 'Sari Lemon California (Small)',
            'category_id' => '1',
            'description' => "Deskripsi Sari Lemon California",
            'size' => '250 ml',
            'price' => '60000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/lemon.jpg'
        ]);

        Product::create([
            'name' => 'Sari Lemon California (Medium)',
            'category_id' => '1',
            'description' => "Deskripsi Sari Lemon California",
            'size' => '500 ml',
            'price' => '100000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/lemon.jpg'
        ]);

        Product::create([
            'name' => 'Safron',
            'category_id' => '1',
            'description' => "Deskripsi Safron",
            'size' => '1 gr',
            'price' => '110000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/safron.jpg'
        ]);

        Product::create([
            'name' => 'Chiaseed (Small)',
            'category_id' => '1',
            'description' => "Deskripsi Chiaseed",
            'size' => '100 gr',
            'price' => '25000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/chiaseed.jpg'
        ]);

        Product::create([
            'name' => 'Chiaseed (Medium)',
            'category_id' => '1',
            'description' => "Deskripsi Chiaseed",
            'size' => '250 gr',
            'price' => '50000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/chiaseed.jpg'
        ]);

        Product::create([
            'name' => 'Granola Honey',
            'category_id' => '1',
            'description' => "Deskripsi Granola Honey",
            'size' => ' gr',
            'price' => '65000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/granola.jpg'
        ]);

        Product::create([
            'name' => 'Madu Hutan (Small)',
            'category_id' => '1',
            'description' => "Deskripsi Madu Hutan",
            'size' => '250 gr',
            'price' => '50000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/madu.jpg'
        ]);

        Product::create([
            'name' => 'Madu Hutan (Medium)',
            'category_id' => '1',
            'description' => "Deskripsi Madu Hutan",
            'size' => '500 gr',
            'price' => '95000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/madu.jpg'
        ]);

        Product::create([
            'name' => 'Madu Hutan (Large)',
            'category_id' => '1',
            'description' => "Deskripsi Madu Hutan",
            'size' => '1000 gr',
            'price' => '180000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/madu.jpg'
        ]);

        Service::create([
            'name' => 'Bekam',
            'category_id' => '2',
            'description' => 'Deskripsi Bekam',
            'duration' => '30',
            'price' => '150000',
            'image_path' => '/service-images/bekam.jpg'
        ]);

        Service::create([
            'name' => 'Akupuntur Kecantikan & Kesehatan',
            'category_id' => '2',
            'description' => 'Deskripsi Akupuntur Kecantikan & Kesehatan',
            'duration' => '30',
            'price' => '125000',
            'image_path' => '/service-images/.jpg'
        ]);

        Service::create([
            'name' => 'Fashdu',
            'category_id' => '2',
            'description' => 'Deskripsi Fashdu',
            'duration' => '30',
            'price' => '100000',
            'image_path' => '/service-images/.jpg'
        ]);

        Service::create([
            'name' => 'Totok Punggung',
            'category_id' => '2',
            'description' => 'Deskripsi Totok Punggung',
            'duration' => '30',
            'price' => '100000',
            'image_path' => '/service-images/totokpunggung.jpg'
        ]);
    }
}
