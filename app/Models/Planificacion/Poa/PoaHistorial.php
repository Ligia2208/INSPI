<?php

namespace App\Models\Planificacion\Poa;

use Illuminate\Database\Eloquent\Model;

class PoaHistorial extends Model
{
    protected $fillable = [
                            'id',
                            'id_poa',
                            'nro_poa',
                            'comentario',
                            'fecha_registro',
                            'estado_poa',
                            'estado',
                            'created_at',
                            'updated_at'
                          ];

    //Logs
    protected static $logName = 'PoaHistorial';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'planificacion';
    public $table = 'pla_poa_historial';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un POA ha sido {$eventName}";
    }


}
