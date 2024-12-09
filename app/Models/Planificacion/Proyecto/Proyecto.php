<?php

namespace App\Models\Planificacion\Proyecto;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $fillable = [
                            'id',
                            'id_programa',
                            'nombre',
                            'descripcion',
                            'estado',
                            'created_at',
                            'updated_at'
                          ];

    //Logs
    protected static $logName = 'Proyecto';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'db_inspi_planificacion';
    public $table = 'pla_proyecto';
    
    public function getDescriptionForEvent(string $eventName)
    {
        return "Un POA ha sido {$eventName}";
    }


}
