<?php

namespace App\Models\Lamina\Lamina;

use Illuminate\Database\Eloquent\Model;

class Lamina extends Model
{
    protected $fillable = [
        'id_evento',
        'id_tecnica',
        'id_unidad_salud',
        'id_analista',
        'id_responsable',
        'mes_recepcion',
        'fecha_recep',
        'anio',
        'total_laminas',
        'total_laminas_recib',
        'laminas_positivas_rec',
        'laminas_negativas_rec',
        'director_us',
        'observaciones',
        'laminas_empacadas',
        'laminas_legibles',
        'laminas_sin_id',
        'laminas_sin_aceite',
        'laminas_frotis_adecuado',
        'laminas_integras',
        'laminas_documentacion',
        'fecha_ini',
        'fecha_fin',
        'cod_microscopia',
        'estado',
        'created_at',
        'updated_at'
    ];

    //Logs
    protected static $logName = 'Laminas';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'crns';
    public $table = 'ingreso_laminas';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Una Actividad Operativa ha sido {$eventName}";
    }


}