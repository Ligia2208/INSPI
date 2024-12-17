<?php

namespace App\Models\Planificacion\Comentario;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $fillable = [
                            'id',
                            'id_poa',
                            'id_usuario',
                            'comentario',
                            'estado_planificacion',
                            'estado',
                            'created_at',
                            'updated_at'
                          ];

    //Logs
    protected static $logName = 'Comentario';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'planificacion';
    public $table = 'pla_comentario';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un POA ha sido {$eventName}";
    }


}
