<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'ألعاب' => 'Games',
            'ملابس' => 'Clothes',
            'كتب' => 'Books',
            'كمبيوتر' => 'Computers',
            'أكسسوارات' => 'Accessories',
        ];


        foreach ($categories as $key => $value) {
            Category::create([
                'name_ar' => $key,
                'name_en' => $value,
            ]);
        }
    }
}
