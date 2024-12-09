<?php

namespace App\Models\Planificacion\ActividadPre;

use Illuminate\Database\Eloquent\Model;

class ActividadPre extends Model
{
    protected $fillable = [
                            'id',
                            'id_proyecto',
                            'nombre',
                            'descripcion',
                            'estado',
                            'created_at',
                            'updated_at'
                          ];

    //Logs
    protected static $logName = 'ActividadPre';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'db_inspi_planificacion';
    public $table = 'pla_actividad_act';
    
    public function getDescriptionForEvent(string $eventName)
    {
        return "Un POA ha sido {$eventName}";
    }


}
