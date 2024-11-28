<?php

namespace App\Models\RecursosHumanos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Modalidad extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Modalidades';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'rhumanos';
    public $table = 'modalidades';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Una Modalidad ha sido {$eventName}";
    }


}
