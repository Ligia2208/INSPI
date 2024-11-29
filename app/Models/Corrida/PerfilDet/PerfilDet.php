<?php

namespace App\Models\Corrida\PerfilDet;

use Illuminate\Database\Eloquent\Model;

class PerfilDet extends Model
{

    protected $fillable =
        [
            'id',
            'temperatura',
            'tiempo',
            'ciclos',
            'estado',
            'id_perfil',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'PerfilDet';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'corrida';
    public $table = 'cor_perfil_det';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
