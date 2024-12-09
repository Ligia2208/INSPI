<?php

namespace App\Models\Planificacion\Poa;

use Illuminate\Database\Eloquent\Model;

class Poa extends Model
{
    protected $fillable = [
                            'id',
                            'id_institucion',
                            'id_czonal',
                            'id_area',
                            'id_user',
                            'id_obj_est',
                            'id_obj_ins',
                            'id_obj_ope',
                            'indicador',
                            'act_ope',
                            'id_prioridad',
                            'monto float',
                            'chc_automatica',
                            'chc_manual',
                            'frecuencia',
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
                            'tipo_compra',
                            'solicitud_autorizacion',
                            'comentario',
                            'objeto_c',
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
    protected static $logName = 'Poas';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'db_inspi_planificacion';
    public $table = 'pla_poa';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un POA ha sido {$eventName}";
    }


}
