<?php

namespace App\Models\RecursosHumanos;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;
use App\Models\CoreBase\Area;
use App\Models\CoreBase\Direccion;
use App\Models\CoreBase\Cargo;
use App\Models\CoreBase\TipoDiscapacidad;

class Filiacion extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Filiaciones';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'rhumanos';
    public $table = 'filiaciones';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Una Filiación ha sido {$eventName}";
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function direccion()
    {
        return $this->belongsTo(Direccion::class);
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function escala()
    {
        return $this->belongsTo(Escala::class);
    }

    public function tipodiscapacidad()
    {
        return $this->belongsTo(TipoDiscapacidad::class);
    }

    public function modalidad()
    {
        return $this->belongsTo(Modalidad::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }
}
