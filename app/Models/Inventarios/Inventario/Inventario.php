<?php

namespace App\Models\Inventarios\Inventario;

use App\Models\Inventarios\Kit\Kit;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{

    protected $fillable =
        [
            'id',
            'id_lote',
            'id_laboratorio',
            'cantidad',
            'cant_minima',
            'id_unidad',
            'estado',
            'created_at',
            'updated_at',
        ];

    //Logs
    protected static $logName = 'Inventario';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'inventarios';
    public $table = 'inv_inventario';
    //protected $primaryKey = 'id';


    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Módulo ha sido {$eventName}";
    }


    public static function actualizarInventario($idLote, $nuevaCantidad, $id_laboratorio, $id_unidad)
    {
        // Buscar el artículo en el inventario por id_articulo
        $inventarioExistente = self::where('id_lote', $idLote)
            ->where('id_laboratorio', $id_laboratorio)
            ->where('id_unidad', $id_unidad)->first();

        if ($inventarioExistente) {
            // Si el artículo existe, actualizar la cantidad
            $cantidadTotal = $inventarioExistente->cantidad + $nuevaCantidad;
            $minimo = $cantidadTotal * 0.15;
            $inventarioExistente->update([
                'cantidad'    => $cantidadTotal,
                'cant_minima' => $minimo
            ]);
            return $inventarioExistente->id;
        } else {
            // Si el artículo no existe, crear un nuevo registro
            $minimo = $nuevaCantidad * 0.15;
            $nuevoInventario = self::create([
                'id_lote'        => $idLote,
                'cantidad'       => $nuevaCantidad,
                'id_laboratorio' => $id_laboratorio,
                'cant_minima'    => $minimo,
                'estado'         => 'A', 
                'id_unidad'      => $id_unidad,
            ]);
            return $nuevoInventario->id;
        }
    }


    protected static function boot()
    {
        parent::boot();

        // Escuchar el evento created
        static::created(function ($inventario) {
            // Crear un nuevo registro de kit
            Kit::create([
                'id_inventario' => $inventario->id,
            ]);
        });
    }


}
