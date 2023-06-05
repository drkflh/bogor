<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestUtil extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:clear {--mode=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear Test Data';

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
     * @return int
     */
    public function handle()
    {

        $this->testMode = $this->option('mode') ?? false;

        DB::collection( 'notifications' )
            ->raw()
            ->deleteMany([]);

        DB::collection( 'freshchecks' )
            ->raw()
            ->deleteMany([]);

        DB::collection( 'pregnantchecks' )
            ->raw()
            ->deleteMany([]);

        DB::collection( 'usgchecks' )
            ->raw()
            ->deleteMany([]);

        DB::collection( 'estruschecks' )
            ->raw()
            ->deleteMany([]);

        DB::collection( 'inseminations' )
            ->raw()
            ->deleteMany([]);

        DB::collection( 'cattleprofiles' )
            ->raw()
            ->deleteMany([]);

        DB::collection( 'console_log' )
            ->raw()
            ->deleteMany([]);

        return 0;
    }
}
