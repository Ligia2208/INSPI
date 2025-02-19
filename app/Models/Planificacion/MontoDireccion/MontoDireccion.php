<?php

namespace App\Models\Planificacion\MontoDireccion;

use Illuminate\Database\Eloquent\Model;

class MontoDireccion extends Model
{

    protected $fillable =
        [
            'id',
            'id_dir',
            'id_dir_tec',
            'nombre',
            'descripcion',
            'monto',
            'id_fuente',
            'proceso_estado',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'MontoDireccion';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'planificacion';
    public $table = 'pla_direcciones';
    //protected $primaryKey = 'id';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }
}
