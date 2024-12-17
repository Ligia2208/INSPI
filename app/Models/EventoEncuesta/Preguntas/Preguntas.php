<?php


namespace App\Models\EventoEncuesta\Preguntas;
use Illuminate\Database\Eloquent\Model;

class Preguntas extends Model
{

    protected $fillable = [ 'id',
                            'encuesta_id',
                            'pregunta',
                            'tipo_respuesta',
                            'abrindada',
                            'estado',
                            'created_at',
                            'updated_at'
                        ];

    //Logs
    protected static $logName = 'Preguntas';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'encuestas';
    public $table = 'enc_preguntas';
    //protected $primaryKey = 'id_asignacion';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
