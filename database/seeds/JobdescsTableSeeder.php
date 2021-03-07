<?php

use Illuminate\Database\Seeder;

class JobdescsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jobdescs')->insert([
            'jobname' => 'Project Manager',
        ],
        [
            'jobname' => 'Software Engineer',
        ],
        [
            'jobname' => 'System Analyst',
        ]);
    }
}
