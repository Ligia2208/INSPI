<?php

namespace App\Models\EventoEncuesta\LaboratorioResp;

use Illuminate\Database\Eloquent\Model;

class LaboratorioResp extends Model
{

    protected $fillable =
        [
            'id',
            'id_encuestausuario',
            'id_tipoEncuesta',
            'id_laboratorio',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'LaboratorioResp';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'encuestas';
    public $table = 'enc_laboratorioresp';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
