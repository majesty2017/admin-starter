<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 50; $i++) {
            $user = User::create([
                'name' => "Test $i",
                'is_admin' => 0,
                'email' => "test$i@test.com",
                'email_verified_at' => now(),
                'password' => bcrypt('T1sc077a'), // password
                'remember_token' => Str::random(10),
            ]);
        }

        $role = Role::where('id', 5)->first();
        $user->syncRoles($role);
    }
}
