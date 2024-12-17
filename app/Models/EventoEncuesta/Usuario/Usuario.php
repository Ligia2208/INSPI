<?php

namespace App\Models\EventoEncuesta\Usuario;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{

    protected $fillable =
        [
            'id',
            'usuario_id',
            'nombre',
            'descripcion',
            'apellido',
            'correo',
            'hospital',
            'password',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'Usuario';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'encuestas';
    public $table = 'enc_usuario';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
