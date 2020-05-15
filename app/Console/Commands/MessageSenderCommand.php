<?php

namespace App\Console\Commands;

use App\Client;
use App\Jobs\SendMessage;
use App\ScheduleMessage;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MessageSenderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sender:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Message sender command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        // we run command every minute

        // 1) find messages in this time
        // 2) calculate time with timezone
        // 3) send job with delay

        $now = Carbon::now();
        $time = $now->setTimezone(config('app.timezone'))->toTimeString();

        $hour = explode(':', $time)[0];
        $min = explode(':', $time)[1];

        ScheduleMessage::where('time', "{$hour}:{$min}:00")->chunk(200, function ($messages) use ($now, $time) {
            foreach ($messages as $schedule_message) {
                Client::chunk(200, function ($clients) use ($now, $time, $schedule_message) {
                    foreach ($clients as $client) {
                        $client_time = Carbon::parse($now->setTimezone($client->timezone)->toTimeString());
                        $diff = Carbon::parse($time)->diffInHours($client_time, true);

                        if ($diff === 0) {
                            SendMessage::dispatch($client, $schedule_message->message);
                        } else {
                            SendMessage::dispatch($client, $schedule_message)->delay(60 * 60 * $diff);
                        }
                    }
                });
            }
        });
    }
}
