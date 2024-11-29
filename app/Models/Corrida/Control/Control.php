<?php

namespace App\Models\Corrida\Control;

use Illuminate\Database\Eloquent\Model;

class Control extends Model
{

    protected $fillable =
        [
            'id',
            'id_corrida',
            'total',
            'umbral',
            'automatic',            
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'Control';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'corrida';
    public $table = 'cor_control';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
