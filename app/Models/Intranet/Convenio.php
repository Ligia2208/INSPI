<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;

class Convenio extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Convenios';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'intranet';
    public $table = 'incon_convenios';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Convenio ha sido {$eventName}";
    }

    public function estadoconvenio()
    {
        return $this->belongsTo(Estado::class);
    }

    public function institucionprincipal()
    {
        return $this->belongsTo(Institucion::class);
    }

    public function ambitoconvenio()
    {
        return $this->belongsTo(Ambito::class);
    }

    public function contactointerno()
    {
        return $this->belongsTo(User::class);
    }

}
