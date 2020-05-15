<?php

use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Client::class, 50)->create();
        factory(\App\Message::class, 50)->create()->each(function ($message) {
            $message->schedules()->save(factory(App\ScheduleMessage::class)->make());
        });
    }
}
