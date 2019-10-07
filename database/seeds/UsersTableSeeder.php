<?php

use Illuminate\Database\Seeder;
// use App\Models\Role;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        // $adminRole = Role::where('name', 'administrator')->first();
        // $subAdminRole = Role::where('name', 'sub administrator')->first();
        // $publisherRole = Role::where('name', 'publisher')->first();
        // $studentRole = Role::where('name', 'student')->first();

        $admin = User::create([
            'email' => 'admin@mail.com',
            'password' => bcrypt('password'),
        ]);

        // $subadmin = User::create([
        //     'email' => 'subadmin@mail.com',
        //     'password' => bcrypt('password'),
        // ]);
        $publisher = User::create([
            'first_name' => 'publisher',
            'email' => 'publisher@mail.com',
            'password' => bcrypt('password'),
            'department_id' => 1,
        ]);
        $student = User::create([
            'first_name' => 'student',
            'email' => 'student@mail.com',
            'password' => bcrypt('password'),
            'department_id' => 2,
        ]);

        // $admin->roles()->attach($adminRole);
        // $subadmin->roles()->attach($subAdminRole);
        // $publisher->roles()->attach($publisherRole);
        // $student->roles()->attach($studentRole);
    }
}
