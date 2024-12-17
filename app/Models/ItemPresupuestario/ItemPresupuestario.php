<?php

namespace App\Models\ItemPresupuestario;

use Illuminate\Database\Eloquent\Model;

class ItemPresupuestario extends Model
{

    protected $fillable =
        [
            'id',
            'nombre',
            'descripcion',
            'monto',
            'monto_ini',
            'estado',
            'created_at',
            'updated_at'
        ];

    //Logs
    protected static $logName = 'ItemPresupuestario';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'planificacion';
    public $table = 'pla_item_presupuestario';
    //protected $primaryKey = 'id';

    //para solo reiniciar uno
    public function resetMontos()
    {
        $this->monto = 0.00;
        $this->monto_ini = 0.00;
        $this->save();
    }

    //para reiniciar todos los valores
    public static function resetAllMontos()
    {
        self::query()->update(['monto' => 0.00, 'monto_ini' => 0.00]);
    }


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }
}
