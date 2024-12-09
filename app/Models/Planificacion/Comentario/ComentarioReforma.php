<?php

namespace App\Models\Planificacion\Comentario;

use Illuminate\Database\Eloquent\Model;

class ComentarioReforma extends Model
{
    protected $fillable = [
                            'id',
                            'id_reforma',
                            'id_usuario',
                            'comentario',
                            'estado_planificacion',
                            'estado',
                            'created_at',
                            'updated_at'
                          ];

    //Logs
    protected static $logName = 'ComentarioReforma';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'db_inspi_planificacion';
    public $table = 'pla_comentario_reforma';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un comentario de la reforma ha sido {$eventName}";
    }
}
