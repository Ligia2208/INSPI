<?php

namespace App\Models\Planificacion\Contador;

use Illuminate\Database\Eloquent\Model;

class Contador extends Model
{
    protected $fillable = [
                            'id',
                            'zonal',
                            'anio',
                            'valor',
                            'estado',
                            'created_at',
                            'updated_at'
                          ];

    //Logs
    protected static $logName = 'Contador';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'planificacion';
    public $table = 'pla_contador';
    
    public function getDescriptionForEvent(string $eventName)
    {
        return "Un POA ha sido {$eventName}";
    }


}
