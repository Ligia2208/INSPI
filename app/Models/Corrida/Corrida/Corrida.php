<?php

namespace App\Models\Corrida\Corrida;

use Illuminate\Database\Eloquent\Model;

class Corrida extends Model
{

    protected $fillable =
        [
            'id',
            'id_analista',
            'extraccion_equi',
            'equipos', 
            'numero',            
            'tecnica', 
            'servicio', 
            'hora', 
            'fecha', 
            'vigilacia_tipo', 
            'estacional',
            'variante',
            'observacion',
            'id_laboratorio',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'Corrida';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'corrida';
    public $table = 'cor_corrida';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
