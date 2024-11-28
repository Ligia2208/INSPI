<?php

namespace App\Models\Corrida\Estandar;

use Illuminate\Database\Eloquent\Model;

class Estandar extends Model
{

    protected $fillable =
        [
            'id',
            'id_corrida',
            'estandar',
            'concentra',      
            'ct',  
            'interpreta',              
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'Estandar';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'corrida';
    public $table = 'cor_estandar';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
