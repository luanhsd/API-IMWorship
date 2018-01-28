<?php

use Illuminate\Database\Seeder;

class SchedulesTeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\ScheduleTeam::class, 10)->create();
    }
}
