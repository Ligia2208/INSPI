<?php

namespace App\Models\Plataformas;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class Tratamiento extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Tratamiento';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false; 
    protected $connection = 'plataformas';
    public $table = 'tratamientos';
    

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un registro de Tratamiento ha sido {$eventName}";
    }

}
