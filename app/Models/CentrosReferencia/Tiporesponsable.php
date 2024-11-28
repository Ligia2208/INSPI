<?php

namespace App\Models\CentrosReferencia;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;


class Tiporesponsable extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'TIPO RESPONSABLE';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'crns';
    public $table = 'tipo_responsables';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Tipo Responsable de CRN ha sido {$eventName}";
    }


}
