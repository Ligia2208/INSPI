<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Tecnico extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Técnico TICs';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'intranet';
    public $table = 'intic_tecnicos';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Técnico TICs ha sido {$eventName}";
    }


}
