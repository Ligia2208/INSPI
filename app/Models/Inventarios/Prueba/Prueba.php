<?php

namespace App\Models\Inventarios\Prueba;

use Illuminate\Database\Eloquent\Model;

class Prueba extends Model
{

    protected $fillable =
        [
            'id',
            'id_laboratorio',
            'nombre',
            'descripcion',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'Prueba';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'inventarios';
    public $table = 'inv_prueba';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
