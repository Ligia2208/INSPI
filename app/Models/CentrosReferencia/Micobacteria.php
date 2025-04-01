<?php

namespace App\Models\CentrosReferencia;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;


class Micobacteria extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Datos de micobacteria';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'crns';
    public $table = 'micobacteria';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Reporte de resultados ha sido {$eventName}";
    }

}
