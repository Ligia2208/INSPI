<?php

namespace App\Models\Planificacion\Fuente;

use Illuminate\Database\Eloquent\Model;

class Fuente extends Model
{
    protected $fillable = [
                            'id',
                            'id_actividad',
                            'nombre',
                            'descripcion',
                            'estado',
                            'created_at',
                            'updated_at'
                          ];

    //Logs
    protected static $logName = 'Fuente';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'db_inspi_planificacion';
    public $table = 'pla_fuente';
    
    public function getDescriptionForEvent(string $eventName)
    {
        return "Un POA ha sido {$eventName}";
    }


}
