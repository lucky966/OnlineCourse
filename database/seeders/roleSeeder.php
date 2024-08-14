<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class roleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ownerRole = Role::create([
            'name' => 'owner',
        ]);

        $teacherRole = Role::create([
            'name' => 'teacher'
        ]);
        $studentRole = Role::create([
            'name' => 'student'
        ]);

        $user = User::create([
            'name' => 'Jaka Owner',
            'email' => 'jaka@owner.com',
            'password' => bcrypt('jaka#123'),
            'eccupation'=> 'Educator',
            'avatar'=> 'image/avatar-default.png',
        ]);

        $user->assignRole($ownerRole);
    }
    }

