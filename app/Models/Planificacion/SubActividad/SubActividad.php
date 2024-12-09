<?php

namespace App\Models\Planificacion\SubActividad;

use Illuminate\Database\Eloquent\Model;

class SubActividad extends Model
{
    protected $fillable = [
                            'id',
                            'id_area',
                            'nombre',
                            'estado',
                            'created_at',
                            'updated_at'
                          ];

    //Logs
    protected static $logName = 'SubActividad';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'mysql';
    public $table = 'inspi_sub_actividad';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Objetivo Operativo ha sido {$eventName}";
    }


}
