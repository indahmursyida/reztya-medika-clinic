<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

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

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Category::create([
            'category_name' => 'Body Care'
        ]);

        Category::create([
            'category_name' => 'SkinCare'
        ]);
        
        Product::create([
            'name' => 'Body Shower',
            'category_id' => '1',
            'description' => "Lorem, ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit dolor dolores laudantium ipsa earum non et accusantium sint voluptate error necessitatibus accusamus laboriosam impedit est, maxime tempora perferendis sunt quia.",
            'size' => '100',
            'price' => '150000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/bodyshower.jpg'
        ]);
    }
}
