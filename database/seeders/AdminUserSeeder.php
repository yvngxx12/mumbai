<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@mumbai.com');
        $password = env('ADMIN_PASSWORD');

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin',
                'password' => Hash::make($password ?: Str::random(32)),
            ],
        );

        if ($password !== null && ! Hash::check($password, $user->password)) {
            $user->forceFill(['password' => Hash::make($password)])->save();
        }
    }
}
