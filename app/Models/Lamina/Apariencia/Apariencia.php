<?php

namespace App\Models\Lamina\Apariencia;

use Illuminate\Database\Eloquent\Model;

class Apariencia extends Model
{
    protected $fillable = [
        'id',
        'nombre',
        'descripcion',
        'estado',
        'created_at',
        'updated_at'
    ];

    //Logs
    protected static $logName = 'Apariencia';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'crns';
    public $table = 'apariencia_microscopica';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Una Actividad Operativa ha sido {$eventName}";
    }


}