<?php

namespace App\Models\Inventarios\Lote;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{

    protected $fillable =
        [
            'id',
            'id_articulo',
            'id_marca',
            'nombre',
            'f_elabora',
            'f_caduca',
            'caduca',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'Lote';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'inventarios';
    public $table = 'inv_lote';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
