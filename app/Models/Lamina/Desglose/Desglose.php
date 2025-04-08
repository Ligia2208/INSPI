<?php

namespace App\Models\Lamina\Desglose;

use Illuminate\Database\Eloquent\Model;

class Desglose extends Model
{
    protected $fillable = [
        'id',
        'nro_lamina',
        'lectura',
        'id_apariencia',
        'id_frotis',
        'id_tincion',
        'id_lamina',
        'estado',
        'created_at',
        'updated_at'
    ];

    //Logs
    protected static $logName = 'Desglose';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'crns';
    public $table = 'desglose_lamina';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Una Actividad Operativa ha sido {$eventName}";
    }


}