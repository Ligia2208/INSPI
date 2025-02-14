<?php

namespace App\Models\CentrosReferencia;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;


class Preanalitica extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Toma de muestras';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'crns';
    public $table = 'pre_analitica';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Reporte de resultados ha sido {$eventName}";
    }

    public function instituciones()
    {
        return $this->belongsTo(Institucion::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function sedes()
    {
        return $this->belongsTo(Sede::class);
    }

    public function crns()
    {
        return $this->belongsTo(Crn::class);
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function tecnica()
    {
        return $this->belongsTo(Tecnica::class);
    }

    public function usuariot()
    {
        return $this->belongsTo(User::class);
    }

    public function usuarior()
    {
        return $this->belongsTo(User::class);
    }

    public function resultado()
    {
        return $this->belongsTo(Reporte::class);
    }

    public function primera()
    {
        return $this->belongsTo(Muestra::class);
    }

    public function segunda()
    {
        return $this->belongsTo(Muestra::class);
    }

    public function tercera()
    {
        return $this->belongsTo(Muestra::class);
    }

    public function cuarta()
    {
        return $this->belongsTo(Muestra::class);
    }

    public function quinta()
    {
        return $this->belongsTo(Muestra::class);
    }

    public function analitica(){
        return $this->hasMany(Analitica::class);
    }

}
