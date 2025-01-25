<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class HouseType extends Model
{
    use HasFactory;

    protected $table = 'house_types'; // Указываем имя таблицы

    // Указываем разрешенные поля для массового присваивания
    protected $fillable = [
        'id',
        'name',
        'shortname',
        'desc',
        'is_active',
        'update_date',
        'start_date',
        'end_date',
    ];

    // Включаем автоматическое добавление timestamp'ов
    public $timestamps = true;
}