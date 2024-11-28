<?php

namespace App\Models\Inventarios\Contador;

use Illuminate\Database\Eloquent\Model;

class Contador extends Model
{

    protected $fillable =
        [
            'id',
            'no_ingreso',
            'no_egreso',
            'no_donacion',
            'no_traspaso',
            'no_ajuste',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'Contador';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'inventarios';
    public $table = 'inv_contador';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
