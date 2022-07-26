<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $categories = Category::all();

        foreach ($categories as $category) {
            for ($i = 1; $i <= 20000; $i++) {
                Product::create([
                    'category_id'       => $category->id,
                    'name_ar'           => $category->name_ar . ' ar ' . $i,
                    'name_en'           => $category->name_en . ' en ' . $i,
                    'description_ar'    => 'ar ' . $faker->randomLetter() . ' description ',
                    'description_en'    => 'en ' . $faker->randomLetter() . ' description ',
                    'purchase_price'    => $faker->randomFloat(2, 100, 5500),
                    'sale_price'        => $faker->randomFloat(2, 100, 5500),
                    'image'             => 'https://via.placeholder.com/720x520?text=' . str_replace(' ', '+', $category->name) . '+' . $i,
                    'stock'             => $faker->randomFloat(2, 100, 1000),
                ]);
            }
        }
    }
}
