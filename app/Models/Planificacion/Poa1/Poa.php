<?php

namespace App\Models\Planificacion\Poa1;

use Illuminate\Database\Eloquent\Model;

class Poa extends Model
{
    protected $fillable = [
                            'id',
                            'departamento',
                            'id_area',
                            'id_usuario',
                            'id_obj_operativo',
                            'id_actividad',
                            'id_sub_actividad',
                            'id_tipo_monto',
                            'id_tipo_poa',
                            'u_ejecutora',
                            'programa',
                            'proyecto',
                            'actividad',
                            'fuente',
                            'id_item',
                            'id_consumo',
                            'monto',
                            'presupuesto_proyectado',
                            'plurianual',
                            'planificada',
                            'fecha',
                            'nro_poa',
                            'año',
                            'estado',
                            'created_at',
                            'updated_at'
                          ];

    //Logs
    protected static $logName = 'Poa';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'planificacion';
    public $table = 'pla_poa1';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un POA ha sido {$eventName}";
    }


}
