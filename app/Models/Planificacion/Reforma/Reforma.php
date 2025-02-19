<?php

namespace App\Models\Planificacion\Reforma;

use Illuminate\Database\Eloquent\Model;

class Reforma extends Model {
    protected $fillable = [
        'id',
        'nro_solicitud',
        'nro_reforma',
        'area_id',
        'justificacion',
        'justificacion_area',
        'tipo',
        'fecha',
        'estado',
        'created_at',
        'updated_at'
      ];

    //Logs
    protected static $logName = 'Reforma';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'planificacion';
    public $table = 'pla_reforma';

    public function getDescriptionForEvent(string $eventName)
    {
    return "Una reforma ha sido {$eventName}";
    }

    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'id_reforma');
    }


}
