<?php

namespace App\Models\Planificacion\Solicitud;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $fillable = [
                            'id',
                            'id_actividad',
                            'id_area_solicitante',
                            'id_area_propietaria',
                            'estado_solicitud',
                            'fecha_solicitud',
                            'fecha_respuesta',
                            'nota',
                            'estado',
                            'created_at',
                            'updated_at'
                          ];

    //Logs
    protected static $logName = 'Solicitud';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'planificacion';
    public $table = 'pla_solicitud';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Objetivo Operativo ha sido {$eventName}";
    }


}
