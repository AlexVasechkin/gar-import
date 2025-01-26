<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Throwable;
use SimpleXMLElement;
use Illuminate\Support\Facades\File;

ini_set('memory_limit', '8G');

class HandleFileJob implements ShouldQueue
{
    use Queueable;

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
        $xmlReader = new \XMLReader();
        $xmlReader->open($this->filePath);

        while ($xmlReader->read()) {
            if ($xmlReader->nodeType == \XMLReader::ELEMENT && $xmlReader->localName == $this->xmlProperty) {
                $item = new SimpleXMLElement($xmlReader->readOuterXML());
                $data = $this->modelClassName::parseData($item);
                UpdateOrCreateJob::dispatch($this->modelClassName, $data);
            }
        }

        $xmlReader->close();
    }

    public function failed(Throwable $e): void
    {
        Log::error(implode(PHP_EOL, [
            $e->getMessage(),
            $e->getTraceAsString()
        ]));
    }
}
