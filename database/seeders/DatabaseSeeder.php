<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'memberFirstName',
            'middle_name' => 'memberMIddleName',
            'last_name' => 'memberLastName',
            'age' => 23,
            'role' => 'member',
            'email' => 'member@example.com',
            'password' => 'admin'
        ]);
    }
}
