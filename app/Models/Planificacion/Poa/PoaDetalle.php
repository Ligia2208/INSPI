<?php

namespace App\Models\Planificacion\Poa;

use Illuminate\Database\Eloquent\Model;

class PoaDetalle extends Model
{
    protected $fillable = [
                            'id',
                            'id_poa',
                            'tipo_compra',
                            'id_bien',
                            'cantidad',
                            'precio_unitario',
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
    protected static $logName = 'PoaDetalles';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'db_inspi_planificacion';
    public $table = 'pla_poa_detalle';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un POA_DETALLE ha sido {$eventName}";
    }


}
