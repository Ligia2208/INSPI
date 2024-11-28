<?php

namespace App\Models\GestionDocumental;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\CoreBase\Area;
use App\Models\GestionDocumental\EstadoSolicitud;

class Seguimiento extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Seguimiento';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'documental';
    public $table = 'asignaciones';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Seguimiento ha sido {$eventName}";
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function estado()
    {
        return $this->belongsTo(EstadoSolicitud::class);
    }



}
