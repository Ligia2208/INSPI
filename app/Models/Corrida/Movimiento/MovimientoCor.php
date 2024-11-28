<?php

namespace App\Models\Corrida\Movimiento;

use Illuminate\Database\Eloquent\Model;

class MovimientoCor extends Model
{

    protected $fillable =
        [
            'id',
            'id_usuario',
            'id_lote',
            'cantidad',
            'valor',   
            'total', 
            'prueba',
            'fecha', 
            'ini_saldo',
            'fin_saldo',   
            'id_movimiento_inv',  
            'id_corrida', 
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'Movimiento';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'corrida';
    public $table = 'cor_movimiento';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
