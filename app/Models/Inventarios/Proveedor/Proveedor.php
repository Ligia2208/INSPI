<?php

namespace App\Models\Inventarios\Proveedor;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{

    protected $fillable =
        [
            'id',
            'nombre',
            'ruc',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'Proveedor';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'inventarios';
    public $table = 'inv_proveedor';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
