<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Throwable;

class RunSeederJob implements ShouldQueue
{
    use Queueable;

    protected string $seederClass;

    public $tries = 1;

    public function __construct(string $seederClass)
    {
        $this->seederClass = $seederClass;
        $this->onQueue('seeders');
    }

    public function handle(): void
    {
        (new $this->seederClass())->run();
    }

    public function failed(Throwable $e): void
    {
        Log::error(implode(PHP_EOL, [
            $e->getMessage(),
            $e->getTraceAsString()
        ]));
    }
}
