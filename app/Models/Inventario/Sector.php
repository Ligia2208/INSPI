<?php

namespace App\Models\Inventario;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class Sector extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Sector';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'inventario';
    public $table = 'sectores';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Sector ha sido {$eventName}";
    }

}
