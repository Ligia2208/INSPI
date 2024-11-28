<?php

namespace App\Models\Soporte;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;


class Estadosoporte extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Estado soporte';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'soporte';
    public $table = 'tsupport_estados';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Estado de soporte ha sido {$eventName}";
    }

}
