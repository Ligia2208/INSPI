<?php

namespace App\Models\Inventario;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class Estado extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Estado';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'inventario';
    public $table = 'estados';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Estado ha sido {$eventName}";
    }

}
