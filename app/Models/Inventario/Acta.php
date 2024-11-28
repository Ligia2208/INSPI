<?php

namespace App\Models\Inventario;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;


class Acta extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Actas';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'inventario';
    public $table = 'actas';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Una Acta ha sido {$eventName}";
    }

}
