<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Evidencia extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Evidencia';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'intranet';
    public $table = 'ineve_evidencia';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Una Evidencia de Evento ha sido {$eventName}";
    }

    public function tipoevidencia()
    {
        return $this->belongsTo(Tipoevidencia::class);
    }


}
