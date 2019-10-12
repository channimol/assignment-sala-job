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
            array(
                'name' => 'Health and Science',
            ),
            array(
                'name' => 'Food and Chemical Industry',
            ),
        );

        DB::table('departments')->truncate();
        foreach ($departments as $department) {
            DB::table('departments')->insert($department);
        }
    }
}
