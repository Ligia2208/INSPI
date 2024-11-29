<?php

namespace App\Models\Corrida\ReactivoMono;

use Illuminate\Database\Eloquent\Model;

class ReactivoMono extends Model
{

    protected $fillable =
        [
            'id',
            'id_monoclonal',
            'id_reactivo',        
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'ReactivoMono';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'corrida';
    public $table = 'cor_reactivo_mono';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
