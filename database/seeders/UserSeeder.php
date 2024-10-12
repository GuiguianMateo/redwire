<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Bouncer;

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
            'motif-restore',
            'absence-create',
            'absence-show',
            'absence-edit',
            'absence-delete',
            'absence-restore',
            'user-create',
            'user-show',
            'user-edit',
            'user-delete',
            'user-restore',
        ]);

        Bouncer::assign('admin')->to($admin);

        $salarie = User::create([
            'name' => 'salarie',
            'email' => 'salarie@gmail.com',
            'password' => Hash::make('salariesalarie'),
        ]);

        Bouncer::allow('salarie')->to([
            'absence-create',
            'absence-show',
            'user-show',
        ]);

        Bouncer::assign('salarie')->to($salarie);

        User::factory()
            ->count(15)
            ->create();
    }
}
