<?php

namespace App\Models\EventoEncuesta\LaboratorioEncuesta;

use Illuminate\Database\Eloquent\Model;

class LaboratorioEncuesta extends Model
{

    protected $fillable =
        [
            'id',
            'laboratorio_id',
            'tipoencuesta_id',
            'valor',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'LaboratorioEncuesta';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'encuestas';
    public $table = 'enc_laboratorioencuesta';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
