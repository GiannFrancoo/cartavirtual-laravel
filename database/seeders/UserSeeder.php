<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [   
                'name'     => 'admin',
                'email'    => 'admin@admin.com',
                'role_id'  => Role::ADMIN,
                'password' => Hash::make('admin'),
            ],
            [ 
                'name'     => 'mozo',
                'email'    => 'mozo@mozo.com',            
                'role_id'  => Role::MOZO,
                'password' => Hash::make('mozo'),
            ],
            [ 
                'name'     => 'mozo1',
                'email'    => 'mozo1@mozo1.com',            
                'role_id'  => Role::MOZO,
                'password' => Hash::make('mozo1'),
            ],
            [
                'name'     => 'gian',
                'email'    => 'giannfrancoo1@hotmail.com',
                'role_id'   => Role::ADMIN,
                'password'  => Hash::make('gian'),
            ],
            [
                'name'  => 'fernando',
                'email' => 'hfmartinez85@gmail.com',
                'role_id' => Role::ADMIN,
                'password' => Hash::make('fernando'),
            ]
        ];
        
        foreach ($users as $user) {
            $checkUser = User::where('name',$user['name'])->first();
            if (!$checkUser) {
                User::create($user);
            }
        }
    }
}
