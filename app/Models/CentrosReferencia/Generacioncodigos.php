<?php
namespace App\Models\CentrosReferencia;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;


class Generacioncodigos extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Generacion de codigos';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'crns';
    public $table = 'generacion_codigos';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Generacion de codigos ha sido {$eventName}";
    }

    public function sedes()
    {
        return $this->belongsTo(Sede::class);
    }

    public function crns()
    {
        return $this->belongsTo(Crn::class);
    }

    public function muestra()
    {
        return $this->belongsTo(Muestra::class);
    }

    public function tipo()
    {
        return $this->belongsTo(Tipogeneracion::class);
    }

}
