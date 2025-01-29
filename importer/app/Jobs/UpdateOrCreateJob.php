<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Throwable;

class UpdateOrCreateJob implements ShouldQueue
{
    use Queueable;

    protected string $className;
    protected array $data;

    public $tries = 1;

    /**
     * Create a new job instance.
     */
    public function __construct(string $className, array $data)
    {
        $this->className = $className;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $this->className::updateOrCreate($this->data[0] ?? [], $this->data[1] ?? []);
        } catch (Throwable $e) {
            $this->handleError($e);
        }
    }

    /**
     * Обработка ошибок
     */
    protected function handleError(Throwable $e): void
    {
        Log::error('Ошибка при выполнении задания UpdateOrCreateJob: ' . $e->getMessage());
    }
}
