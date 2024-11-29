<?php

namespace App\Models\GestionDocumental;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\CoreBase\Area;

class Solicitudenv extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Solicitudes Asignadas';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'documental';
    public $table = 'solicitudes';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Una Solicitud ha sido {$eventName}";
    }

    public function origen()
    {
        return $this->belongsTo(Origen::class);
    }

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function destino()
    {
        return $this->belongsTo(Destino::class);
    }

}
