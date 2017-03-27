<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ObjectiveComplete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
     protected $signature = 'chat:message {message}';

    /**
     * The console command description.
     *
     * @var string
     */
     protected $description = 'Send chat message.';

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
    // public function handle()
    // {
    //     // Fire off an event, just randomly grabbing the first user for now
    //     //$user = \App\User::first();
    //     $message = \App\ObjectiveComplete::create([
    //         'message' => "Big test"
    //     ]);
    //
    //
    //     event(new \App\Events\ObjectiveComplete($message));
    // }



    public function handle()
    {
        // Fire off an event, just randomly grabbing the first user for now
        $user = \App\User::first();
        // dd($user);
        $message = \App\ObjectiveComplete::create([
            'user_id' => $user->id,
            'message' => $this->argument('message')
        ]);
        // dd($message);
        event(new \App\Events\ObjectiveComplete($message, $user));


    }

}
