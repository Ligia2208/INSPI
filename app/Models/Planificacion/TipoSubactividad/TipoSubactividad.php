<?php

namespace App\Models\Planificacion\TipoSubactividad;

use Illuminate\Database\Eloquent\Model;

class TipoSubactividad extends Model
{
    protected $fillable = [
                            'id',
                            'id_poa',
                            'nombre',
                            'estado',
                            'created_at',
                            'updated_at'
                          ];

    //Logs
    protected static $logName = 'TipoSubactividad';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'planificacion';
    public $table = 'pla_tipo_subactividad';
    
    public function getDescriptionForEvent(string $eventName)
    {
        return "Un POA ha sido {$eventName}";
    }


}
