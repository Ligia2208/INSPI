<?php

namespace App\Models\Soporte;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;


class Prioridad extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Prioridades';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'soporte';
    public $table = 'tsupport_prioridades';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Una Prioridad ha sido {$eventName}";
    }

}
