<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $availability = [
            [
                'day' => 'monday',
                'available' => true
            ],
            [
                'day' => 'tuesday',
                'available' => true
            ],
            [
                'day' => 'wednesday',
                'available' => true
            ],
            [
                'day' => 'thursday',
                'available' => true
            ],
            [
                'day' => 'friday',
                'available' => true
            ],
        ];

        $justin = User::firstOrCreate([
            'name' => 'Justin',
            'email' => 'justin@test.com',
            'password' => 'tijdelijk',
            'availability' => json_encode($availability)
        ]);

        $wouter = User::firstOrCreate([
            'name' => 'Wouter',
            'email' => 'wouter@test.com',
            'password' => 'tijdelijk',
            'availability' => json_encode($availability)
        ]);

        $superAdmin = Role::firstOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'web'
        ]);

        $justin->assignRole($superAdmin);
        $wouter->assignRole($superAdmin);
    }
}
