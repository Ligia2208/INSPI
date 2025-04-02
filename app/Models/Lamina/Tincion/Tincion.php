<?php

namespace App\Models\Lamina\Tincion;

use Illuminate\Database\Eloquent\Model;

class Tincion extends Model
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
    protected static $logName = 'Tincion';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'crns';
    public $table = 'calidad_tincion';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Una Actividad Operativa ha sido {$eventName}";
    }


}