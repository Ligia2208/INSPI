<?php

namespace App\Models\Inventarios\Unidad;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{

    protected $fillable =
        [
            'id',
            'nombre',
            'abreviatura',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'Unidad';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'inventarios';
    public $table = 'inv_unidad';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
