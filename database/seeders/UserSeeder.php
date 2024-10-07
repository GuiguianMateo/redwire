<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('adminadmin'),
        ]);

        Bouncer::allow('admin')->to([
            'motif-create',
            'motif-show',
            'motif-edit',
            'motif-delete',
            'absence-create',
            'absence-show',
            'absence-edit',
            'absence-delete',
            'user-create',
            'user-show',
            'user-edit',
            'user-delete',
        ]);

        Bouncer::assign('admin')->to($admin);

        User::factory()
            ->count(15)
            ->create();
    }
}
