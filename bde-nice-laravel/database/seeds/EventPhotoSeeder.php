<?php

use Illuminate\Database\Seeder;

class EventPhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\EventPhoto', 200)->create();
    }
}
