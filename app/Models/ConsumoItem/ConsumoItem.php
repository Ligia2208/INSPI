<?php

namespace App\Models\ConsumoItem;

use Illuminate\Database\Eloquent\Model;

class ConsumoItem extends Model
{

    protected $fillable =
        [
            'id',
            'id_item',
            'id_actividad',
            'monto_consumido',
            'monto',
            'fecha',
            'anio',
            'tipo',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'ConsumoItem';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'planificacion';
    public $table = 'pla_consumo_item';
    //protected $primaryKey = 'id';

    public static function actualizarEstadosPorIdItem($id_item)
    {
        return self::where('id_item', $id_item)->update(['estado' => 'E']);
    }

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }
}
