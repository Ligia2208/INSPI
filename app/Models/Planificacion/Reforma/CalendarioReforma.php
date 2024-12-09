<?php

namespace App\Models\Planificacion\Reforma;

use Illuminate\Database\Eloquent\Model;

class CalendarioReforma extends Model {
    protected $fillable = [
        'id',
        'id_actividad',
        'id_poa',
        'tipo',
        'enero',
        'febrero',
        'marzo',
        'abril',
        'mayo',
        'junio',
        'julio',
        'agosto',
        'septiembre',
        'octubre',
        'noviembre',
        'diciembre',
        'total',
        'estado',
        'created_at',
        'updated_at'
      ];

    //Logs
    protected static $logName = 'CalendarioReforma';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'planificacion';
    public $table = 'pla_calendario_ref';

    public function getDescriptionForEvent(string $eventName)
    {
    return "Una reforma ha sido {$eventName}";
    }
}
