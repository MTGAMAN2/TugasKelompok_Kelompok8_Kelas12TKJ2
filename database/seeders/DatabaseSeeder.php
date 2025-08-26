<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $this->call(CategorySeeder::class);

        $roleUser = Role::where('name', 'User')->first();

        $user = User::updateOrCreate(
            ['email' => 'juangalexander@gmail.com'],
            [
                'name' => 'Juang Alexander',
                'password' => bcrypt('juangganteng123'),
                'role_id' => $roleUser->id,
            ]
        );

        // Wallets
        Wallet::updateOrCreate(
            [
                'user_id' => $user->id,
                'name' => 'Cash',
            ],
            ['balance' => 0]
        );

        Wallet::updateOrCreate(
            [
                'user_id' => $user->id,
                'name' => 'Bank BCA',
            ],
            ['balance' => 1000000]
        );
    }
}
