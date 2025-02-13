<?php
namespace App\Traits;

use App\Models\RecursosHumanos\Filiacion;
use App\Models\Planificacion\MontoDireccion\MontoDireccion;
use Illuminate\Support\Facades\Auth;

trait GetDireccionTrait
{
    public function obtenerDireccion()
    {
        $id_user = Auth::user()->id;
        $filiacion = Filiacion::with('area')->where('user_id', $id_user)->first();

        if (!$filiacion) {
            return null; // Retorna null si no encuentra filiación
        }

        $id_area = $filiacion->area_id;
        $direccion_id = $filiacion->direccion_id;

        $direccion = ($id_area == 7)
            ? MontoDireccion::select('id', 'monto', 'id_fuente', 'nombre')->where('id_dir_tec', $direccion_id)->first()
            : MontoDireccion::select('id', 'monto', 'id_fuente', 'nombre')->where('id_dir', $id_area)->first();

        if (!$direccion) {
            return null; // Retorna null si no encuentra la dirección
        }

        return [
            'id_direccion' => $direccion->id,
            'id_fuente'    => $direccion->id_fuente,
            'nombre'       => $direccion->nombre
        ];
    }
}
