<?php

namespace App\Models\Inventarios\Marca;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{

    protected $fillable =
        [
            'id',
            'nombre',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'Marca';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'inventarios';
    public $table = 'inv_marca';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
