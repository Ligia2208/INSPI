<?php

namespace App\Models\CoreBase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class EstadoCivil extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Estado Civil';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'coreinspi';
    public $table = 'estadoscivil';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Estado Civil ha sido {$eventName}";
    }


}
