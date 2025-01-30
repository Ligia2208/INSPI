<?php

namespace App\Models\Planificacion\ItemDireccion;

use Illuminate\Database\Eloquent\Model;

class ItemDireccion extends Model
{

    protected $fillable =
        [
            'id',
            'id_direcciones',
            'id_item',
            'monto',
            'presupuesto',
            'certificado',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'ItemDireccion';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'planificacion';
    public $table = 'pla_items_direcciones';
    //protected $primaryKey = 'id';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }
}
