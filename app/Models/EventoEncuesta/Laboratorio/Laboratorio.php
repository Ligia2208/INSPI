<?php

namespace App\Models\EventoEncuesta\Laboratorio;

use Illuminate\Database\Eloquent\Model;

class Laboratorio extends Model
{

    protected $fillable =
        [
            'id',
            'area_id',
            'descripcion',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'Laboratorio';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'encuestas';
    public $table = 'enc_laboratorio';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
