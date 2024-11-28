<?php

namespace App\Models\Corrida\Monoclonal;

use Illuminate\Database\Eloquent\Model;

class Monoclonal extends Model
{

    protected $fillable =
        [
            'id',
            'id_corrida',
            'fecha',
            'muestra',
            'usuario_id',   
            'reactivo_id',         
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'Monoclonal';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'corrida';
    public $table = 'cor_monoclonal';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
