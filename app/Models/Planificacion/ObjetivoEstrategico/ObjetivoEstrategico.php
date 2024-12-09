<?php

namespace App\Models\Planificacion\ObjetivoEstrategico;

use Illuminate\Database\Eloquent\Model;

class ObjetivoEstrategico extends Model
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
    protected static $logName = 'ObjetivosEst';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'planificacion';
    public $table = 'inspi_obj_estrategico';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Objetivo Estratégico ha sido {$eventName}";
    }


}
