<?php

namespace App\Models\Planificacion\UnidadEjecutora;

use Illuminate\Database\Eloquent\Model;

class UnidadEjecutora extends Model
{
    protected $fillable = [
                            'id',
                            'nombre',
                            'descripcion',
                            'estado',
                            'created_at',
                            'updated_at'
                          ];

    //Logs
    protected static $logName = 'UnidadEjecutora';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'planificacion';
    public $table = 'pla_unidad_ejecutora';
    
    public function getDescriptionForEvent(string $eventName)
    {
        return "Un POA ha sido {$eventName}";
    }


}
