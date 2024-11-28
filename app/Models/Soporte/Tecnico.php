<?php

namespace App\Models\Soporte;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;


class Tecnico extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Técnicos';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'soporte';
    public $table = 'tsupport_tecnicos';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Técnico ha sido {$eventName}";
    }

}
