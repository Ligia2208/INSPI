<?php

namespace App\Models\Planificacion\ContadorRef;

use Illuminate\Database\Eloquent\Model;

class ContadorRef extends Model
{
    protected $fillable = [
                            'id',
                            'tipo',
                            'anio',
                            'valor',
                            'estado',
                            'created_at',
                            'updated_at'
                          ];

    //Logs
    protected static $logName = 'ContadorRef';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'planificacion';
    public $table = 'pla_contador_ref';
    
    public function getDescriptionForEvent(string $eventName)
    {
        return "Un POA ha sido {$eventName}";
    }


}
