<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class GetCountCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            
        } catch (Throwable $e) {
            $m = implode(PHP_EOL, [
                $e->getMessage(),
                $e->getTraceAsString()
            ]);
            echo $m . PHP_EOL;
            Log::error($m);
        }
    }
}
