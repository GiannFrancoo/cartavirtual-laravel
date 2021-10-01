<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories =  [
            [
                'name' => 'Pizzas',
            ],
            [   
                'name' => 'Tapeos',
            ],
            [
                'name' => 'Birras',
            ],
            [
                'name' => 'Postres',
            ]
        ];
        
        foreach ($categories as $category) {
            $checkCategory = Category::where('name', $category['name'])->first();
            if (!$checkCategory) {
                Category::create($category);
            }
        }
    }
}
