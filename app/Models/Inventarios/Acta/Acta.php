<?php

namespace App\Models\Inventarios\Acta;

use Illuminate\Database\Eloquent\Model;

class Acta extends Model
{

    protected $fillable =
        [
            'id',
            'nombre',
            'proveedor',
            'fecha',
            'tipo',
            'transaccion',
            'origen',
            'recibe',
            'no_ingreso',
            'numero',
            'factura',
            'n_contrato',
            'descripcion',
            'total',
            'estado',
            'id_laboratorio',
            'transferible',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'Acta';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'inventarios';
    public $table = 'inv_acta';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
