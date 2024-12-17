<?php

namespace App\Models\EventoEncuesta\EncuestaUser;

use Illuminate\Database\Eloquent\Model;

class EncuestaUser extends Model
{

    protected $fillable =
        [
            'id',
            'id_encuesta',
            'id_usuario',
            'nombre',
            'descripcion',
            'comentario',
            'ciudad',
            'name_unidad', 
            'id_area',
            'servicio',
            'servidor_publico',
            'motivo_califica',
            'id_evento',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'EncuestaUser';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'encuestas';
    public $table = 'enc_encuesta_user';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
