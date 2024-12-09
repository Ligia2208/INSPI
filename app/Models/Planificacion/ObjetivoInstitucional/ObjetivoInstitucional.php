<?php

namespace App\Models\Planificacion\ObjetivoInstitucional;

use Illuminate\Database\Eloquent\Model;

class ObjetivoInstitucional extends Model
{
    protected $fillable = [
                            'id',
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
    protected static $logName = 'ObjetivosIns';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'mysql';
    public $table = 'inspi_obj_institucional';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Objetivo Institucional ha sido {$eventName}";
    }


}
