<?php

namespace App\Models\CentrosReferencia;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;


class Crn extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'CRN';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'crns';
    public $table = 'crns';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un CRN ha sido {$eventName}";
    }

}
