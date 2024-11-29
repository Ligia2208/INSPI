<?php

namespace App\Models\CoreBase;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Direcciontecnica extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Direcciones Tecnicas';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'coreinspi';
    public $table = 'direcciones_tecnicas';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Una Dirección Técnica ha sido {$eventName}";
    }

    public function direccion()
    {
        return $this->belongsTo(Direccion::class);
    }

}
