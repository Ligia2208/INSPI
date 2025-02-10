<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Resolucion extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Resolución INSPI';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'intranet';
    public $table = 'inres_resoluciones';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Una Resolución INSPI ha sido {$eventName}";
    }

    public function director()
    {
        return $this->belongsTo(Director::class);
    }

    public function tipo()
    {
        return $this->belongsTo(Tiporesolucion::class);
    }


}
