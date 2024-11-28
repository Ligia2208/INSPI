<?php

namespace App\Models\CentrosReferencia;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;


class SedeCrn extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'SEDE-CRN';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'crns';
    public $table = 'sedes_crns';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Una combinación SEDE CRN ha sido {$eventName}";
    }

}
