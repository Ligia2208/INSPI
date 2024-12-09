<?php

namespace App\Models\Planificacion\ActividadOperativa;

use Illuminate\Database\Eloquent\Model;

class ActividadOperativa extends Model
{
    protected $fillable = [
                            'id',
                            'id_area',
                            'nombre',
                            'fecha_inicio',
                            'fecha_fin',
                            'estado',
                            'operador_ing',
                            'operador_act',
                            'terminal_ing',
                            'terminal_act',
                            'ip_ing',
                            'ip_act',
                            'created_at',
                            'updated_at'
                          ];

    //Logs
    protected static $logName = 'ActOperativas';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'planificacion';
    public $table = 'pla_actividad_operativa';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Una Actividad Operativa ha sido {$eventName}";
    }


}
