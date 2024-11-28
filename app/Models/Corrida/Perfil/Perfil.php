<?php

namespace App\Models\Corrida\Perfil;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{

    protected $fillable =
        [
            'id',
            'id_corrida',
            'canales',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'Perfil';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'corrida';
    public $table = 'cor_perfil';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
