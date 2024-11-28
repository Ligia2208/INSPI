<?php

namespace App\Models\CoreBase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Nacionalidad extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Nacionalidad';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'coreinspi';
    public $table = 'nacionalidades';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Una Nacionalidad ha sido {$eventName}";
    }


}
