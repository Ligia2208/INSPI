<?php

namespace App\Models\EventoEncuesta\UsuarioLaboratorio;

use Illuminate\Database\Eloquent\Model;

class UsuarioLaboratorio extends Model
{

    protected $fillable =
        [
            'id',
            'laboratorio_id',
            'tipoencuesta_id',
            'usuario_id',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'UsuarioLaboratorio';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'encuestas';
    public $table = 'enc_usuariolaboratorio';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
