<?php

namespace App\Models\Planificacion\Reforma;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model {
    protected $fillable = [
        'id',
        'id_poa',
        'id_reforma',
        'sub_actividad',
        'estado',
        'created_at',
        'updated_at'
      ];

    //Logs
    protected static $logName = 'Actividad';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'db_inspi_planificacion';
    public $table = 'pla_actividad';

    public function getDescriptionForEvent(string $eventName)
    {
    return "Una actividad ha sido {$eventName}";
    }
}
