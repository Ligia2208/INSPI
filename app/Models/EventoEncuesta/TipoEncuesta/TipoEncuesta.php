<?php

namespace App\Models\EventoEncuesta\TipoEncuesta;

use Illuminate\Database\Eloquent\Model;

class TipoEncuesta extends Model
{

    protected $fillable =
        [
            'id',
            'encuesta_id',
            'nombre',
            'tipo',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'TipoEncuesta';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'encuestas';
    public $table = 'enc_tipoencuesta';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
