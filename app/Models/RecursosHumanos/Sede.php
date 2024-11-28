<?php

namespace App\Models\RecursosHumanos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Sede extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Sedes';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'rhumanos';
    public $table = 'sedes';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Una Sede ha sido {$eventName}";
    }


}
