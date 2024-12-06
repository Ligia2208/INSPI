<?php

namespace App\Models\EventoEncuesta\Servicios;

use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{

    protected $fillable =
        [
            'id',
            'nombre',
            'descripcion',
            'id_laboratorio',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'Servicios';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'encuestas';
    public $table = 'enc_servicios';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
