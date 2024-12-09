<?php

namespace App\Models\Planificacion\Programa;

use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    protected $fillable = [
                            'id',
                            'id_unidad',
                            'nombre',
                            'descripcion',
                            'estado',
                            'created_at',
                            'updated_at'
                          ];

    //Logs
    protected static $logName = 'Programa';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'planificacion';
    public $table = 'pla_programa';
    
    public function getDescriptionForEvent(string $eventName)
    {
        return "Un POA ha sido {$eventName}";
    }


}
