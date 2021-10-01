<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles =  [
            [
                'name' => 'admin',
                'id'   => Role::ADMIN,
            ],
            [
                'name' => 'mozo',
                'id'   => Role::MOZO,
            ]
        ];
        
        foreach ($roles as $role) {
            $checkRole = Role::find($role['id']);
            if (!$checkRole) {
                Role::create($role);
            }
        }
    }
}
