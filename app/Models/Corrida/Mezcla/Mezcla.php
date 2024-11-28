<?php

namespace App\Models\Corrida\Mezcla;

use Illuminate\Database\Eloquent\Model;

class Mezcla extends Model
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
    protected static $logName = 'Mezcla';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'corrida';
    public $table = 'cor_mezcla';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
