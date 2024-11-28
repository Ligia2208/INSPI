<?php

namespace App\Models\Inventarios\Categoria;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
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
    protected static $logName = 'Categoria';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'inventarios';
    public $table = 'inv_categoria';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
