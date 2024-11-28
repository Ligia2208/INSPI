<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\CoreBase\Area;

class Revision extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Evento INSPI';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'intranet';
    public $table = 'ineve_eventos';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Evento INSPI ha sido {$eventName}";
    }

    public function tipoactividad()
    {
        return $this->belongsTo(Tipoactividad::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }


}
