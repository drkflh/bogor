<?php

namespace App\Console\Commands;

use App\Helpers\App\MmsUtil;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class TestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email {--m=} {--to=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to test email sending';

    protected $m = '';
    protected $to = '';

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
        $this->m = $this->option('m') ?? 'test';
        $this->to = $this->option('to') ?? 'andy.awidarto@gmail.com';

        $rec['to'] = $this->to;
        $rec['name'] = 'AA';
        $rec['cc'] = [];
        $rec['bcc'] = [];

        $data['_id'] = Str::random(16);
        $data['email_verification'] = Str::random(16);

        MmsUtil::sendEmail($rec, 'Email Testing' , $data, $this->m);

        return 0;
    }
}
