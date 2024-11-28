<?php

namespace App\Models\Corrida\MezclaDet;

use Illuminate\Database\Eloquent\Model;

class MezclaDet extends Model
{

    protected $fillable =
        [
            'id',
            'id_examen',
            'rx',
            'rt',
            'cant',
            'solucion',
            'id_mezcla',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'MezclaDet';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'corrida';
    public $table = 'cor_mezcla_det';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
