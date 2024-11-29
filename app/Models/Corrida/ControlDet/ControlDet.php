<?php

namespace App\Models\Corrida\ControlDet;

use Illuminate\Database\Eloquent\Model;

class ControlDet extends Model
{

    protected $fillable =
        [
            'id',
            'control_id',
            'ct',
            'resultado', 
            'criterios',            
            'id_control',            
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'ControlDet';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'corrida';
    public $table = 'cor_control_det';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
