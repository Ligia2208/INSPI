<?php

namespace App\Models\Planificacion\TipoPoa;

use Illuminate\Database\Eloquent\Model;

class TipoPoa extends Model
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
    protected static $logName = 'TipoPoa';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'planificacion';
    public $table = 'pla_tipo_poa';
    
    public function getDescriptionForEvent(string $eventName)
    {
        return "Un POA ha sido {$eventName}";
    }


}
