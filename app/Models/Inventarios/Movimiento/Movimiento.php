<?php

namespace App\Models\Inventarios\Movimiento;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{

    protected $fillable =
        [
            'id',
            'id_usuario',
            'id_lote',
            'unidades',
            'uni_medida',
            'precio',
            'precio_total',
            'saldo_ini',
            'saldo_fin',
            'id_acta',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'Movimiento';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'inventarios';
    public $table = 'inv_movimiento';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
