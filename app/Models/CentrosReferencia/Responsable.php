<?php

namespace App\Models\CentrosReferencia;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;


class Responsable extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'RESPONSABLE';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'crns';
    public $table = 'responsables';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Responsable de CRN ha sido {$eventName}";
    }

    public function sedes()
    {
        return $this->belongsTo(Sede::class);
    }

    public function crns()
    {
        return $this->belongsTo(Crn::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function tipo()
    {
        return $this->belongsTo(Tiporesponsable::class);
    }

}
