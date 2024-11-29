<?php

namespace App\Models\Corrida\Extraccion;

use Illuminate\Database\Eloquent\Model;

class Extraccion extends Model
{

    protected $fillable =
        [
            'id',
            'id_lote',
            'id_corrida',
            'numero', 
            'observacion',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'Extraccion';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'corrida';
    public $table = 'cor_extraccion';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
