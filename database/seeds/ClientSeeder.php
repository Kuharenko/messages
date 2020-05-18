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
        $arr = range(0, 2000);
        foreach($arr as $index) {
            factory(\App\Client::class, 500)->create();
        }

        factory(\App\Message::class, 10000)->create()->each(function ($message) {
            $message->schedules()->save(factory(App\ScheduleMessage::class)->make());
        });
    }
}
