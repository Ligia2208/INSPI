<?php

namespace App\Models\Planificacion\TipoMonto;

use Illuminate\Database\Eloquent\Model;

class TipoMonto extends Model
{
    protected $fillable = [
                            'id',
                            'id_poa',
                            'nombre',
                            'estado',
                            'created_at',
                            'updated_at'
                          ];

    //Logs
    protected static $logName = 'TipoMonto';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'db_inspi_planificacion';
    public $table = 'pla_tipo_monto';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un POA ha sido {$eventName}";
    }


}
