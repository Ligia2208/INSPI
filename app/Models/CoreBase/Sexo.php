<?php

namespace App\Models\CoreBase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Sexo extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Sexo';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'coreinspi';
    public $table = 'sexos';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Sexo ha sido {$eventName}";
    }


}
