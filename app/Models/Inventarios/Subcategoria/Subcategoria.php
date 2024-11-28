<?php

namespace App\Models\Inventarios\Subcategoria;

use Illuminate\Database\Eloquent\Model;

class Subcategoria extends Model
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
    protected static $logName = 'Subcategoria';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'inventarios';
    public $table = 'inv_subcategoria';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
