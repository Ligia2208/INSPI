<?php

namespace App\Models\EventoEncuesta\ServiciosEnc;

use Illuminate\Database\Eloquent\Model;

class ServiciosEnc extends Model
{

    protected $fillable =
        [
            'id',
            'id_servicio',
            'id_encuesta',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'ServiciosEnc';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'encuestas';
    public $table = 'enc_servicios_enc';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
