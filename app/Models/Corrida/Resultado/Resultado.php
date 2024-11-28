<?php

namespace App\Models\Corrida\Resultado;

use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{

    protected $fillable =
        [
            'id',
            'id_corrida',
            'f_procesa',
            'f_reporte',
            'observacion',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'Resultado';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'corrida';
    public $table = 'cor_resultado';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
