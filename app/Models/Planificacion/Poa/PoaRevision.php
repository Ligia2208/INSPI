<?php

namespace App\Models\Planificacion\Poa;

use Illuminate\Database\Eloquent\Model;

class PoaRevision extends Model
{
    protected $fillable = [
                            'id',
                            'id_poa',
                            'chc_validado',
                            'chc_rechazado',
                            'comentario',
                            'estado',
                            'operador_ing',
                            'operador_act',
                            'terminal_ing',
                            'terminal_act',
                            'ip_ing',
                            'ip_act',
                            'created_at',
                            'updated_at'
                          ];

    //Logs
    protected static $logName = 'PoaRevisiones';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'planificacion';
    public $table = 'pla_poa_revision';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un POA_Revision ha sido {$eventName}";
    }


}
