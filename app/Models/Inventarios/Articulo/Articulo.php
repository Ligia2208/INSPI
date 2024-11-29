<?php

namespace App\Models\Inventarios\Articulo;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{

    protected $fillable =
        [
            'id',
            'nombre',
            'descripcion',
            'id_categoria',
            'id_unidad',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'Articulo';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'inventarios';
    public $table = 'inv_articulo';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
