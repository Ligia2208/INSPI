<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Tipo extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Tipo de Convenio';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'intranet';
    public $table = 'incon_tiposconvenio';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Tipo de Convenio ha sido {$eventName}";
    }


}
