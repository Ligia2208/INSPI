<?php

namespace App\Models\Inventarios\PruebaArticulo;

use Illuminate\Database\Eloquent\Model;

class PruebaArticulo extends Model
{

    protected $fillable =
        [
            'id',
            'id_prueba',
            'id_articulo',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'PruebaArticulo';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'inventarios';
    public $table = 'inv_prueba_articulo';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
