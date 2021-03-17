<?php

use Illuminate\Database\Seeder;
use App\Category;

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
            'laptop',
            'smartphone',
            'tablet',
            'monitor'
        ];

        foreach ($categories as $category_name) {
            $category = new Category();
            $category->name = $category_name;
            $category->slug = getSlug($category_name, 'Category');
            $category->save();
        }
    }
}
