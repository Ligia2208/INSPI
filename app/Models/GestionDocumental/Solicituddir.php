<?php

namespace App\Models\GestionDocumental;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\CoreBase\Area;

class Solicituddir extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Solicitudes Director';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'documental';
    public $table = 'asignaciones';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Una Solicitud de Director ha sido {$eventName}";
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

}
