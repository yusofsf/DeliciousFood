<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class installDeliciousFood extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:DeliciousFood';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Delicious Food App';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('installing packages');
        $install = Process::timeout(360)->run('composer install && npm install');

        if ($install->failed()) {
            $this->error($install->errorOutput());
        } else {
            $this->info('packages installed');
        }

        $this->info('creating .env, generate key and migrate');
        exec('copy .env.example .env', $result);
        $result = Process::timeout(120)->run('php artisan key:generate && php artisan migrate -–seed');

        if ($result->failed() || $result->failed()) {
            $this->error($result->errorOutput() || $result->errorOutput());
        } else {
            $this->info('.env created, key generated and Db migrated');
        }

        $this->info('Building Assets');
        $result = Process::run('npm run build');

        if ($result->failed() ) {
            $this->error($result->errorOutput());
        } else {
            $this->info('Assets Built');
        }
    }
}
