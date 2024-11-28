<?php

namespace App\Models\CoreBase;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Direccion extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Direcciones';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'coreinspi';
    public $table = 'direcciones';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Una Dirección ha sido {$eventName}";
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
    
}
