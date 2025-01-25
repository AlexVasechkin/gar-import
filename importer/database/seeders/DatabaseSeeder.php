<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

ini_set('memory_limit', '2048M');

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            HouseTypesSeeder::class,
            AddressObjectTypesSeeder::class,
            ApartmentTypesSeeder::class,
            NormativeDocsKindsSeeder::class,
            ObjectLevelsSeeder::class,
            OperationTypesSeeder::class,
            ParamTypesSeeder::class,
            RoomTypesSeeder::class,
            AddressObjectsSeeder::class,
            AddressObjectDivisionSeeder::class,
            AddressObjectParametersSeeder::class,
            AdmHierarchySeeder::class,
            ApartmentsSeeder::class,
            ApartmentParametersSeeder::class,
            CarplacesSeeder::class,
            CarplaceParametersSeeder::class,
            ChangeHistorySeeder::class,
            HousesSeeder::class,
            HouseParametersSeeder::class,
            RoomsSeeder::class,
            RoomParametersSeeder::class,
            SteadsSeeder::class,
            SteadParametersSeeder::class,
            MunHierarchySeeder::class,
        ]);
    }
}
