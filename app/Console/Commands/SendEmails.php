<?php

namespace App\Console\Commands;

use Log;
use Illuminate\Console\Command;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send {user} {--queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send drip e-mails to a user';

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
        if ($this->confirm('Do you wish to continue?')) {
            Log::info("Send Email To: {$this->argument('user')} {$this->option('queue')}");

            $this->info("Send Email To: {$this->argument('user')} {$this->option('queue')}");
        }

        $this->error('Something went wrong!');

        $this->line('Display this on the screen');
    }
}
