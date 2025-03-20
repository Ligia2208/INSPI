<?php

namespace App\Models\Planificacion\Poa1;

use Illuminate\Database\Eloquent\Model;
use App\Models\Planificacion\Calendario\Calendario;
use App\Models\Planificacion\Comentario\Comentario;
use App\Models\Planificacion\SubActividad\SubActividad;
use App\Models\Planificacion\ItemDireccion\ItemDireccion;

class Poa extends Model
{
    protected $fillable = [
                            'id',
                            'departamento',
                            'id_area',
                            'id_usuario',
                            'id_obj_operativo',
                            'id_actividad',
                            'id_sub_actividad',
                            'id_tipo_monto',
                            'id_tipo_poa',
                            'id_tipo_sub',
                            'u_ejecutora',
                            'programa',
                            'proyecto',
                            'actividad',
                            'fuente',
                            'id_item',
                            'id_consumo',
                            'id_item_dir',
                            'id_proceso',
                            'monto',
                            'monto_anterior',
                            'monto_certificado',
                            'presupuesto_proyectado',
                            'plurianual',
                            'planificada',
                            'fecha',
                            'nro_poa',
                            'año',
                            'monto_item',
                            'estado',
                            'descargado',
                            'created_at',
                            'updated_at'
                          ];

    //Logs
    protected static $logName = 'Poa';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'planificacion';
    public $table = 'pla_poa1';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un POA ha sido {$eventName}";
    }


    public function crearNuevaActividad($id, $montoActual)
    {
        try {

            // Buscar el POA original por ID
            $poaOriginal = self::find($id);
            if (!$poaOriginal) {
                return false; // Si no existe, retornar false
            }

            // Crear subactividad
            $subActividad = SubActividad::find($poaOriginal->id_sub_actividad);
            $sub = new SubActividad;
            $sub->id_area = $poaOriginal->id_area;
            $sub->nombre  = '(Saldo Planificado) - '.$subActividad->nombre;
            $sub->estado = 'A';
            $sub->save();

            // Crear un nuevo POA con los mismos datos, pero reemplazando el monto
            $nuevoPoa = self::create([
                'departamento'            => $poaOriginal->departamento,
                'id_area'                 => $poaOriginal->id_area,
                'id_usuario'              => $poaOriginal->id_usuario,
                'id_obj_operativo'        => $poaOriginal->id_obj_operativo,
                'id_actividad'            => $poaOriginal->id_actividad,
                'id_sub_actividad'        => $sub->id,
                'id_tipo_monto'           => $poaOriginal->id_tipo_monto,
                'id_tipo_poa'             => $poaOriginal->id_tipo_poa,
                'id_tipo_sub'             => 1,//actividad incluida
                'u_ejecutora'             => $poaOriginal->u_ejecutora,
                'programa'                => $poaOriginal->programa,
                'proyecto'                => $poaOriginal->proyecto,
                'actividad'               => $poaOriginal->actividad,
                'fuente'                  => $poaOriginal->fuente,
                'id_item'                 => $poaOriginal->id_item,
                'id_consumo'              => $poaOriginal->id_consumo,
                'id_item_dir'             => $poaOriginal->id_item_dir,
                'id_proceso'              => $poaOriginal->id_proceso,
                'monto'                   => $montoActual, // Se reemplaza el monto
                //'monto_anterior'          => $poaOriginal->monto, // Guardar el monto anterior
                //'monto_certificado'       => 0, // Se inicia en 0
                'presupuesto_proyectado'  => $poaOriginal->presupuesto_proyectado,
                'plurianual'              => $poaOriginal->plurianual,
                'planificada'             => $poaOriginal->planificada,
                'fecha'                   => now()->toDateString(),
                //'nro_poa'                 => $poaOriginal->nro_poa,
                'año'                     => $poaOriginal->año,
                'monto_item'              => '0.00',
                'estado'                  => 'A', // Se puede ajustar según lógica
                'descargado'              => 0,
            ]);

            // Si el POA no se creó correctamente, hacer rollback
            if (!$nuevoPoa) {
                \DB::rollBack();
                return false;
            }

            // Crear el Calendario asociado
            $calendario = new Calendario();
            $calendario->id_poa     = $nuevoPoa->id;
            $calendario->enero      = 0;
            $calendario->febrero    = 0;
            $calendario->marzo      = 0;
            $calendario->abril      = 0;
            $calendario->mayo       = 0;
            $calendario->junio      = 0;
            $calendario->julio      = 0;
            $calendario->agosto     = 0;
            $calendario->septiembre = 0;
            $calendario->octubre    = 0;
            $calendario->noviembre  = 0;
            $calendario->diciembre  = $montoActual;
            $calendario->total      = $montoActual;
            $calendario->save();

            // Crear el Comentario asociado
            $comentario = new Comentario();
            $comentario->id_poa     = $nuevoPoa->id;
            $comentario->id_usuario = $poaOriginal->id_usuario; // Usuario autenticado
            $comentario->comentario = 'Saldo del monto planificado para ser reformado.';
            $comentario->estado_planificacion = 'Ingresado'; // Estado inicial para una nueva reforma
            $comentario->save();

            // Confirmar la transacción
            \DB::commit();
            return true;

        } catch (\Exception $e) {
            \Log::error('Error al crear nueva actividad en POA: ' . $e->getMessage());
            return false; // En caso de error, retorna false
        }
    }


    public function nuevaActividadLiquidacion($id, $montoActual)
    {
        try {

            // Buscar el POA original por ID
            $poaOriginal = self::find($id);
            if (!$poaOriginal) {
                return false; // Si no existe, retornar false
            }

            // Crear subactividad
            $subActividad = SubActividad::find($poaOriginal->id_sub_actividad);
            $sub = new SubActividad;
            $sub->id_area = $poaOriginal->id_area;
            $sub->nombre  = '(Saldo Liquidado de la certificación POA N°'.$poaOriginal->nro_poa.') - '.$subActividad->nombre;
            $sub->estado = 'A';
            $sub->save();

            // Crear un nuevo POA con los mismos datos, pero reemplazando el monto
            $nuevoPoa = self::create([
                'departamento'            => $poaOriginal->departamento,
                'id_area'                 => $poaOriginal->id_area,
                'id_usuario'              => $poaOriginal->id_usuario,
                'id_obj_operativo'        => $poaOriginal->id_obj_operativo,
                'id_actividad'            => $poaOriginal->id_actividad,
                'id_sub_actividad'        => $sub->id,
                'id_tipo_monto'           => $poaOriginal->id_tipo_monto,
                'id_tipo_poa'             => $poaOriginal->id_tipo_poa,
                'id_tipo_sub'             => 1,//actividad incluida
                'u_ejecutora'             => $poaOriginal->u_ejecutora,
                'programa'                => $poaOriginal->programa,
                'proyecto'                => $poaOriginal->proyecto,
                'actividad'               => $poaOriginal->actividad,
                'fuente'                  => $poaOriginal->fuente,
                'id_item'                 => $poaOriginal->id_item,
                'id_consumo'              => $poaOriginal->id_consumo,
                'id_item_dir'             => $poaOriginal->id_item_dir,
                'id_proceso'              => $poaOriginal->id_proceso,
                'monto'                   => $montoActual, // Se reemplaza el monto
                //'monto_anterior'          => $poaOriginal->monto, // Guardar el monto anterior
                //'monto_certificado'       => 0, // Se inicia en 0
                'presupuesto_proyectado'  => $poaOriginal->presupuesto_proyectado,
                'plurianual'              => $poaOriginal->plurianual,
                'planificada'             => $poaOriginal->planificada,
                'fecha'                   => now()->toDateString(),
                //'nro_poa'                 => $poaOriginal->nro_poa,
                'año'                     => $poaOriginal->año,
                'monto_item'              => '0.00',
                'estado'                  => 'A', // Se puede ajustar según lógica
                'descargado'              => 0,
            ]);

            // Si el POA no se creó correctamente, hacer rollback
            if (!$nuevoPoa) {
                \DB::rollBack();
                return false;
            }

            // Crear el Calendario asociado
            $calendario = new Calendario();
            $calendario->id_poa     = $nuevoPoa->id;
            $calendario->enero      = 0;
            $calendario->febrero    = 0;
            $calendario->marzo      = 0;
            $calendario->abril      = 0;
            $calendario->mayo       = 0;
            $calendario->junio      = 0;
            $calendario->julio      = 0;
            $calendario->agosto     = 0;
            $calendario->septiembre = 0;
            $calendario->octubre    = 0;
            $calendario->noviembre  = 0;
            $calendario->diciembre  = $montoActual;
            $calendario->total      = $montoActual;
            $calendario->save();

            // Crear el Comentario asociado
            $comentario = new Comentario();
            $comentario->id_poa     = $nuevoPoa->id;
            $comentario->id_usuario = $poaOriginal->id_usuario; // Usuario autenticado
            $comentario->comentario = 'Saldo Liquidado de la certificación POA N°-'.$poaOriginal->nro_poa;
            $comentario->estado_planificacion = 'Ingresado'; // Estado inicial para una nueva reforma
            $comentario->save();

            // Confirmar la transacción
            \DB::commit();
            return true;

        } catch (\Exception $e) {
            \Log::error('Error al crear nueva actividad en POA: ' . $e->getMessage());
            return false; // En caso de error, retorna false
        }
    }


    protected static function boot()
    {
        parent::boot();

        /*
        static::creating(function ($actividad) {
            $itemDireccion = ItemDireccion::find($actividad->id_item);

            if (!$itemDireccion) {
                throw ValidationException::withMessages(['id_item' => 'El ítem no existe.']);
            }

            // Verificar que el nuevo monto no supere el monto total asignado
            $montoPresupuestadoActual = $itemDireccion->presupuesto; // Monto ya usado en actividades
            $montoTotalAsignado = $itemDireccion->monto; // Monto disponible

            if (($montoPresupuestadoActual + $actividad->monto) > $montoTotalAsignado) {
                throw ValidationException::withMessages(['monto' => 'El monto de la actividad excede el monto asignado al ítem.']);
            }

            // Actualizar el monto presupuestado sumando la nueva actividad
            $itemDireccion->increment('presupuesto', $actividad->monto);
        });
        */

        static::updating(function ($actividad) {
            if ($actividad->isDirty('estado') && $actividad->estado === 'E') {
                //\Log::info("Marcando actividad POA como eliminada ID: {$actividad->id}");
    
                if ($actividad->id_item_dir) {
                    $itemDireccion = ItemDireccion::find($actividad->id_item_dir);
                    if ($itemDireccion) {
                        $itemDireccion->decrement('presupuesto', $actividad->monto);
                        //\Log::info("Presupuesto actualizado para ItemDireccion ID: {$itemDireccion->id}");
                    } else {
                        //\Log::warning("No se encontró ItemDireccion con ID: {$actividad->id_item_dir}");
                    }
                }
            }
        });

    }


}
