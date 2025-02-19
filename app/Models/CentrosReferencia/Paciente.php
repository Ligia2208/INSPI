<?php

namespace App\Models\CentrosReferencia;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;
use App\Models\CoreBase\Nacionalidad;

class Paciente extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Paciente';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'crns';
    public $table = 'pacientes';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Paciente ha sido {$eventName}";
    }

    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }

    public function canton()
    {
        return $this->belongsTo(Canton::class);
    }

    public function sexo()
    {
        return $this->belongsTo(Sexo::class);
    }

    public function nacionalidad()
    {
        return $this->belongsTo(Nacionalidad::class);
    }

}
