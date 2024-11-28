<?php

namespace App\Models\Plataformas;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class Constante extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Constante';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false; 
    protected $connection = 'plataformas';
    public $table = 'constantes';
    

    public function getDescriptionForEvent(string $eventName)
    {
        return "Una Constante Fisiológica ha sido {$eventName}";
    }

}
