<?php


namespace App\Models\EventoEncuesta\EventoLaboratorio;
use Illuminate\Database\Eloquent\Model;

class EventoLaboratorio extends Model
{

    protected $fillable = [ 
                            'id',
                            'id_evento',
                            'id_labencuesta',
                            'estado',
                            'created_at',
                            'updated_at'
                        ];

    //Logs
    protected static $logName = 'EventoLaboratorio';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'encuestas';
    public $table = 'enc_evento_laboratorio';
    //protected $primaryKey = 'id_asignacion';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
