<?php

namespace App\Models\CentrosReferencia;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;


class Institucion extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Institucion de Salud';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'crns';
    public $table = 'instituciones_salud';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Una Institución de Salud ha sido {$eventName}";
    }

    public function clasificacion()
    {
        return $this->belongsTo(Clasificacion::class);
    }

    public function nivel()
    {
        return $this->belongsTo(Nivel::class);
    }

    public function tipologia()
    {
        return $this->belongsTo(Tipologia::class);
    }

    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }

    public function canton()
    {
        return $this->belongsTo(Canton::class);
    }

}
