<?php


namespace App\Models\EventoEncuesta\OpcionesUser;
use Illuminate\Database\Eloquent\Model;

class OpcionesUser extends Model
{

    protected $fillable = [ 
                            'id',
                            'pregunta_id',
                            'nombre',
                            'respuesta',
                            'estado',
                            'id_opcion_enc',
                            'id_pregun_enc',
                            'created_at',
                            'updated_at'
                        ];

    //Logs
    protected static $logName = 'OpcionesUser';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'encuestas';
    public $table = 'enc_opciones_user';
    //protected $primaryKey = 'id_asignacion';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
