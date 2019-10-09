<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\User;

class RolePermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'Profile: view own Profile',
            'Profile: update own Profile',
            'Job: view job list',
            'Job: apply job',
            'Job: view job',
            'Job: bookmark job',
            'Job: apply job history',
            'User: create user',
            'User: delete user',
            'User: view user',
            'Post: view post',
            'Post: create post',
            'Post: delete post',
        ];


        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'publisher']);
        Role::create(['name' => 'student']);

        $admin_role = Role::find(1);
        $admin_role->syncPermissions([
            'User: create user',
            'User: delete user',
            'User: view user',
            'Post: view post',
            'Post: create post',
            'Post: delete post'
        ]);

        $student_role = Role::find(3);
        $student_role->syncPermissions([
            'Profile: view own Profile',
            'Profile: update own Profile',
            'Job: view job list',
            'Job: apply job',
            'Job: view job',
            'Job: bookmark job',
            'Job: apply job history',
        ]);

        $admin = User::find(1);
        $publisher = User::find(2);
        $student = User::find(3);

        $admin->assignRole('admin');
        $publisher->assignRole('publisher');
        $student->assignRole('student');
    }
}
