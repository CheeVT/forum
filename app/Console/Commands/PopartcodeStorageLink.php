<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PopartcodeStorageLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:popartcode';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        if (file_exists('D:\wamp64\www\popart-uploads')) {
            return $this->error('The "public/storage" directory already exists.');
        }

        $this->laravel->make('files')->link(
            storage_path('app/public'), 'D:\wamp64\www\popart-uploads'
        );

        $this->info('The [public/storage] directory has been linked.');
    }
}
