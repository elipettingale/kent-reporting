<?php

namespace App\Console\Commands;

use App\Mail\TestEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestEmail extends Command
{
    protected $signature = 'app:send-test-email';

    public function handle()
    {
        Mail::to('elipettingale@gmail.com')
            ->send(new TestEmail());

        return Command::SUCCESS;
    }
}
