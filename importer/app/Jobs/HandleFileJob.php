<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Throwable;
use SimpleXMLElement;
use Illuminate\Support\Facades\File;

class HandleFileJob implements ShouldQueue
{
    use Queueable;

    public $tries = 1;

    protected string $filePath;
    protected string $modelClassName;
    protected string $xmlProperty;

    public function __construct(
        string $filePath,
        string $modelClassName,
        string $xmlProperty
    ) {
        $this->filePath = $filePath;
        $this->modelClassName = $modelClassName;
        $this->xmlProperty = $xmlProperty;
        $this->onQueue('files');
    }

    public function handle(): void
    {
        $xmlString = File::get($this->filePath);
        $xml = new SimpleXMLElement($xmlString);
        $this->processXml($xml);
    }

    protected function processXml(SimpleXMLElement $xml): void
    {
        foreach ($xml->{$this->xmlProperty} as $item) {
            $data = $this->modelClassName::parseData($item);
            UpdateOrCreateJob::dispatch($this->modelClassName, $data);
        }
    }

    public function failed(Throwable $e): void
    {
        Log::error(implode(PHP_EOL, [
            $e->getMessage(),
            $e->getTraceAsString()
        ]));
    }
}
