<?php

namespace App\Models\Planificacion\Formulario;

use Illuminate\Database\Eloquent\Model;

class Formulario extends Model
{
    protected $fillable = [
                            'id',
                            'nombre',
                            'apellido',
                            'correo',
                            'telefono',
                            'estado',
                            'created_at',
                            'updated_at',
                          ];

    //Logs
    protected static $logName = 'Formulario';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'planificacion';
    public $table = 'pla_usuario';
    
    public function getDescriptionForEvent(string $eventName)
    {
        return "Un POA ha sido {$eventName}";
    }


}

