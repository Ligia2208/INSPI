<?php

namespace App\Models\CentrosReferencia;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;


class Resultado extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Reporte resultados';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'crns';
    public $table = 'data_resultante';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Reporte de resultados ha sido {$eventName}";
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

    public function resultado()
    {
        return $this->belongsTo(Reporte::class);
    }

}
