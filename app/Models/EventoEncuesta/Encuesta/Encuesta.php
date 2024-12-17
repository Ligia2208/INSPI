<?php

namespace App\Models\EventoEncuesta\Encuesta;

use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{

    protected $fillable =
        [
            'id',
            'nombre',
            'descripcion',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'Encuesta';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'encuestas';
    public $table = 'enc_encuesta';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
