<?php

namespace App\Models\RecursosHumanos;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\CoreBase\TipoDocumento;
use App\Models\CoreBase\Sexo;
use App\Models\CoreBase\Nacionalidad;

class Persona extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Personas';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false; 
    protected $connection = 'rhumanos';
    public $table = 'personas';
    

    public function getDescriptionForEvent(string $eventName)
    {
        return "Una Persona ha sido {$eventName}";
    }

    public function tiposdocumento()
    {
        return $this->belongsTo(TipoDocumento::class);
    }

    public function sexos()
    {
        return $this->belongsTo(Sexo::class);
    }
    
    public function nacionalidades()
    {
        return $this->belongsTo(Nacionalidad::class);
    }
}
