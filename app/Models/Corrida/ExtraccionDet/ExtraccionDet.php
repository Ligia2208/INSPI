<?php

namespace App\Models\Corrida\ExtraccionDet;

use Illuminate\Database\Eloquent\Model;

class ExtraccionDet extends Model
{

    protected $fillable =
        [
            'id',
            'id_muestra',
            'cod_muestra',
            'id_extraccion',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'ExtraccionDet';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'corrida';
    public $table = 'cor_extraccion_det';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
