<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Item;
use App\Models\User;
use Faker\Generator;
use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::truncate();

        $faker = Factory::create();
        $orders =  [
            [   
                'user_id' => User::inRandomOrder()->first()->id,
                'description' => $faker->text(),
                'closed' => rand(0,1),
            ],
            [   
                'user_id' => User::inRandomOrder()->first()->id,
                'description' => $faker->text(),
                'closed' => rand(0,1),
            ],
            [   
                'user_id' => User::inRandomOrder()->first()->id,
                'description' => $faker->text(),
                'closed' => rand(0,1),
            ],
            [   
                'user_id' => User::inRandomOrder()->first()->id,  
                'description' => null,
                'closed' => rand(0,1),
            ]
        ];

        foreach ($orders as $order) {
            $order = Order::create($order);
            $items = Item::inRandomOrder()->limit(rand(1,4))->get();
            $items = $items->pluck('id')->toArray(); //me quedo solo con los ids
            $order->items()->attach($items, ['quantity' => rand(1,20)]);            
        }    
    }
}
