<?php

namespace App\Models\Corrida\ResultadoDet;

use Illuminate\Database\Eloquent\Model;

class ResultadoDet extends Model
{

    protected $fillable =
        [
            'id',
            'ubicacion',
            'f_ingreso',
            'codigo',
            'paciente',
            'procedencia',
            'id_muestra',
            'ensayo',
            'ct',
            'resultado',
            'concentracion',
            'observacion',
            'id_resultado',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'ResultadoDet';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'corrida';
    public $table = 'cor_resultado_det';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
