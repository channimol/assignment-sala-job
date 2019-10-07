<?php

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = array(
            array(
                'name' => 'Human Resource',
            ),
            array(
                'name' => 'Infomation and Communication Technology',
            ),
        );

        DB::table('departments')->truncate();
        foreach ($departments as $department) {
            DB::table('departments')->insert($department);
        }
    }
}
