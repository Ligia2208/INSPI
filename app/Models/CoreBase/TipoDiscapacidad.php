<?php

namespace App\Models\CoreBase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class TipoDiscapacidad extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Tipos de Discapacidad';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'coreinspi';
    public $table = 'tiposdiscapacidad';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Tipo de Discapacidad ha sido {$eventName}";
    }


}
