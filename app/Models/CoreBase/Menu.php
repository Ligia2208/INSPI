<?php

namespace App\Models\CoreBase;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Menu extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Menu';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'coreinspi';
    public $table = 'menus';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un elemento del Menú ha sido {$eventName}";
    }
    
}
