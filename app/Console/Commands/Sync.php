<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi permission';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->line('Initiating permission sync');

        Artisan::call('db:seed', [
            '--class' => 'Database\Seeders\PermissionsSeeder',
            '--force' => true,
        ]);

        $this->line('...');
        $this->line('..');
        $this->line('.');
        $this->line('<bg=green;fg=black;bold> DONE </>');
    }
}
