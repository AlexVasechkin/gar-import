<?php

namespace App\Console\Commands;

use App\Jobs\IndexAddressObjectTypeJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class IndexAddressObjectTypesCommand extends Command
{
    protected $signature = 'app:address-object-type:index';

    protected $description = 'Command description';

    public function handle()
    {
        try {
            $ds = [
                'днп',
                'снт',
                'кп',
                'поселок',
                'п',
                'пос.',
                'поселке',
                'ул.',
                'улица',
                'улице',
                'дом',
                'д',
                'доме',
                'шоссе',
                'проспект',
                'район',
                'районе',
                'г.о.',
                'г. о.',
                'го',
                'г.о',
                'область',
                'днт',
                'городской округ',
                'село',
                'селе',
                'с.'
            ];

            for ($i = 0; $i < count($ds); $i++) {
                IndexAddressObjectTypeJob::dispatch(json_encode([
                    'id' => $i + 1,
                    'name' => $ds[$i]
                ]));
            }
        } catch (Throwable $e) {
            $m = implode(PHP_EOL, [
                $e->getMessage(),
                $e->getTraceAsString()
            ]);
            echo $m;
            Log::error(PHP_EOL, $m);
        }
    }
}
