<?php

namespace App\Models\Planificacion\ObjetivoOperativo;

use Illuminate\Database\Eloquent\Model;

class ObjetivoOperativo extends Model
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
    protected static $logName = 'ObjetivosOp';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'mysql';
    public $table = 'inspi_obj_operativo';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Objetivo Operativo ha sido {$eventName}";
    }


}
