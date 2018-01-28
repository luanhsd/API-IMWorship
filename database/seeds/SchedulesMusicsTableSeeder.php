<?php

use Illuminate\Database\Seeder;

class SchedulesMusicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\ScheduleMusic::class, 10)->create();
    }
}
