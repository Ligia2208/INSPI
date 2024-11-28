<?php

namespace App\Models\Inventario;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;


class Participante extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Participante';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'inventario';
    public $table = 'participantes';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Sector ha sido {$eventName}";
    }

    public function principal()
    {
        return $this->belongsTo(User::class);
    }

    public function guardaalmacen()
    {
        return $this->belongsTo(User::class);
    }

    public function administrativo()
    {
        return $this->belongsTo(User::class);
    }

    public function analista()
    {
        return $this->belongsTo(User::class);
    }

}
