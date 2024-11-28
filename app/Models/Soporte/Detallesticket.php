<?php

namespace App\Models\Soporte;

use Carbon\Carbon;
use App\Models\CoreBase\Area;
use App\Models\CoreBase\Direccion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;

class Detallesticket extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Detalle Tickets Soporte';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'soporte';
    public $table = 'tsupport_detallesticket';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Ticket de Soporte ha sido {$eventName}";
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticketsupport::class);
    }

}
