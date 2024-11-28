<?php

namespace App\Models\GestionDocumental;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;
use App\Models\CoreBase\Area;
use App\Models\CoreBase\Direccion;
use App\Models\GestionDocumental\EstadoSolicitud;

class Asignacion extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Asignaciones';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'documental';
    public $table = 'asignaciones';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Una Solicitud ha sido {$eventName}";
    }

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function direccion()
    {
        return $this->belongsTo(Direccion::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function estado()
    {
        return $this->belongsTo(EstadoSolicitud::class);
    }

}
