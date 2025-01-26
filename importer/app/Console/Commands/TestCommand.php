<?php

namespace App\Console\Commands;

use App\Jobs\RunSeederJob;
use Database\Seeders;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

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
            $seeders = [
                // Seeders\HouseTypesSeeder::class,
                // Seeders\AddressObjectTypesSeeder::class,
                // Seeders\ApartmentTypesSeeder::class,
                // Seeders\NormativeDocsKindsSeeder::class,
                // Seeders\ObjectLevelsSeeder::class,
                // Seeders\OperationTypesSeeder::class,
                // Seeders\ParamTypesSeeder::class,
                // Seeders\RoomTypesSeeder::class,
                Seeders\AddressObjectsSeeder::class,
                // Seeders\AddressObjectDivisionSeeder::class,
                // Seeders\AddressObjectParametersSeeder::class,
                // Seeders\AdmHierarchySeeder::class,
                // Seeders\ApartmentsSeeder::class,
                // Seeders\ApartmentParametersSeeder::class,
                // Seeders\CarplacesSeeder::class,
                // Seeders\CarplaceParametersSeeder::class,
                // Seeders\ChangeHistorySeeder::class,
                // Seeders\HousesSeeder::class,
                // Seeders\HouseParametersSeeder::class,
                // Seeders\RoomsSeeder::class,
                // Seeders\RoomParametersSeeder::class,
                // Seeders\SteadsSeeder::class,
                // Seeders\SteadParametersSeeder::class,
                // Seeders\MunHierarchySeeder::class,
            ];

            foreach ($seeders as $seeder) {
                RunSeederJob::dispatch($seeder);
                // (new $seeder())->run();
            }
        } catch (Throwable $e) {
            Log::error(implode(PHP_EOL, [
                $e->getMessage(),
                $e->getTraceAsString()
            ]));
        }
    }
}
