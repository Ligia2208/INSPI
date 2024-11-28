<?php

namespace App\Models\CoreBase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Cargo extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Cargos';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'coreinspi';
    public $table = 'cargos';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Cargo ha sido {$eventName}";
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function direccion()
    {
        return $this->belongsTo(Direccion::class);
    }

}
