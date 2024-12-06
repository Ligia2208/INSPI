<?php


namespace App\Models\EventoEncuesta\Opciones;
use Illuminate\Database\Eloquent\Model;

class Opciones extends Model
{

    protected $fillable = [ 'id',
                            'pregunta_id',
                            'nombre',
                            'tipo_respuesta',
                            'estado',
                            'created_at',
                            'updated_at'
                        ];

    //Logs
    protected static $logName = 'Opciones';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'encuestas';
    public $table = 'enc_opciones';
    //protected $primaryKey = 'id_asignacion';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
