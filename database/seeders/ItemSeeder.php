<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items =  [
            [
                'name' => 'Pizzas al huevo',
                'description' => 'pizza con panceta, y huevo a caballo',
                'price' => rand(100,500),
                'stock' => rand(100,500),
                'category_id' => Category::where('name', 'Pizzas')->first()->id,
            ],
            [
                'name' => 'Papas columbus',
                'description' => 'Papas cortadas a cuchillo con panceta, verdeo y salchicha alemana',
                'price' => rand(100,500),
                'stock' => rand(100,500),
                'category_id' => Category::where('name', 'Tapeos')->first()->id,
            ],
            [
                'name' => 'IPA Golden',
                'description' => 'Cerveza con rubia, con pizcas de miel y de tonalidad ambár',
                'price' => rand(100,500),
                'stock' => rand(100,500),
                'category_id' => Category::where('name', 'Birras')->first()->id,
            ],
            [
                'name' => 'Cassata',
                'description' => 'Tres sabores, chocolate, vainilla y frutilla',
                'price' => rand(100,360),
                'stock' => rand(100,360),
                'category_id' => Category::where('name', 'Postres')->first()->id,
            ]
        ];
        
        foreach ($items as $item) {
            $checkItem = Item::where('name',$item['name'])->first();
            if (!$checkItem) {
                Item::create($item);
            }
        }
    }
}
