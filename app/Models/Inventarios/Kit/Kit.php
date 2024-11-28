<?php

namespace App\Models\Inventarios\Kit;

use Illuminate\Database\Eloquent\Model;

class Kit extends Model
{

    protected $fillable =
        [
            'id',
            'id_inventario',
            'cantidad',
            'cant_actual',
            'consumido',
            'valor',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'Kit';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'inventarios';
    public $table = 'inv_kit';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


}
