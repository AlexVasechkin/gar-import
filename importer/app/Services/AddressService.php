<?php

namespace App\Services;

class AddressService
{
    public static function getAddressObjectTypesMap(string $objectType): array
    {
        return match ($objectType) {
            "тер. ДНТ" => [],
            "просек" => [],
            "п" => [],
            "б-р" => [],
            "д" => [],
            "м" => [],
            "линия" => [],
            "проезд" => [],
            "г" => [],
            "ул" => [],
            "тер. ОНТ" => [],
            "тер. ГСК" => [],
            "мкр." => [],
            "ал." => [],
            "сад" => [],
            "х" => [],
            "пл-ка" => [],
            "гск" => [],
            "кв-л" => [],
            "км" => [],
            "с" => [],
            "н/п" => [],
            "снт" => [],
            "аллея" => [],
            "пл" => [],
            "ул." => [],
            "туп" => [],
            "пер" => [],
            "тер" => [],
            "ш" => [],
            "наб" => [],
            "пр-д" => [],
            "пр-кт" => [],
            "днп" => [],
            "зона" => [],
            "рп" => [],
            "тер. СПК" => [],
            "г-к" => [],
            "тер." => [],
            "нп" => [],
            "пгт." => [],
            "тер. ДНП" => [],
            "мкр" => [],
            "тер. СНТ" => [],
            "пр-к" => [],
            "пгт" => [],
            "тер. ТСН" => [],
            default => [],
        };
    } 
}
