<?php

namespace App\Models\Lamina\Resultado;

use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    protected $fillable = [
        'id',
        'id_evento',
        'id_tecnica',
        'id_unidad_salud',
        'id_lamina',
        'tecnica_lamina',
        'nro_laminas',
        'porcentaje_laminas',
        'porcentaje_acumulado',
        'interpretacion',
        'estado',
        'created_at',
        'updated_at'
    ];

    //Logs
    protected static $logName = 'Resultado';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'crns';
    public $table = 'resultado_laminas';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Una Actividad Operativa ha sido {$eventName}";
    }


}