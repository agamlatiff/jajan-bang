<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::first();
        if ($user) {
            $user->update(['role' => 'admin']);
            $this->command->info("User {$user->email} updated to admin.");
        } else {
            // Create default admin if no users
            \App\Models\User::factory()->create([
                'name' => 'Admin JajanBang',
                'email' => 'admin@jajanbang.com',
                'password' => bcrypt('password'), // default
                'role' => 'admin'
            ]);
            $this->command->info("Default admin user created.");
        }
    }
}
