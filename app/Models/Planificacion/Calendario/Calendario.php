<?php

namespace App\Models\Planificacion\Calendario;

use Illuminate\Database\Eloquent\Model;

class Calendario extends Model
{
    protected $fillable = [
                            'id',
                            'id_poa',
                            'enero',
                            'febrero',
                            'marzo',
                            'abril',
                            'mayo',
                            'junio',
                            'julio',
                            'agosto',
                            'septiembre',
                            'octubre',
                            'noviembre',
                            'diciembre',
                            'total',
                            'justificacion',
                            'justificacion_area',
                            'estado',
                            'created_at',
                            'updated_at'
                          ];

    //Logs
    protected static $logName = 'Calendario';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'db_inspi_planificacion';
    public $table = 'pla_calendario';

    public function actualizaTotal()
    {
        // Calcular el total sumando los valores de enero a diciembre
        $total = $this->enero + $this->febrero + $this->marzo + $this->abril +
                 $this->mayo + $this->junio + $this->julio + $this->agosto +
                 $this->septiembre + $this->octubre + $this->noviembre +
                 $this->diciembre;

        // Actualizar el campo total
        $this->update(['total' => $total]);
    }

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un POA ha sido {$eventName}";
    }


}
