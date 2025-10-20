<?php

namespace App\Console\Commands;

use App\Services\TelegramService;
use Illuminate\Console\Command;

class TelegramAuth extends Command
{
    protected $signature = 'telegram:auth';
    protected $description = 'Authenticate with Telegram';

    public function handle()
    {
        $telegram = new TelegramService();
        $telegram->initialize();
        try {
            $telegram->start();
            $this->info('Successfully authenticated with Telegram!');
        } catch (\Exception $e) {
            $this->error('Authentication failed: ' . $e->getMessage());
        }
    }
}