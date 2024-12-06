<?php


namespace App\Models\EventoEncuesta\PreguntasUser;
use Illuminate\Database\Eloquent\Model;

class PreguntasUser extends Model
{

    protected $fillable = [ 'id',
                            'encuesta_id',
                            'pregunta',
                            'tipo_respuesta',
                            'estado',
                            'created_at',
                            'updated_at'
                        ];

    //Logs
    protected static $logName = 'PreguntasUser';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'encuestas';
    public $table = 'enc_preguntas_user';
    //protected $primaryKey = 'id_asignacion';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
