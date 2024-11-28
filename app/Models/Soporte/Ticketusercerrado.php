<?php

namespace App\Models\Soporte;

use Carbon\Carbon;
use App\Models\CoreBase\Area;
use App\Models\CoreBase\Direccion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;


class Ticketusercerrado extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Tickets Soporte';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'soporte';
    public $table = 'tsupport_tickets';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Ticket de Soporte ha sido {$eventName}";
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function tecnico()
    {
        return $this->belongsTo(Tecnico::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function identificador()
    {
        return $this->belongsTo(Identiicador::class);
    }

    public function prioridad()
    {
        return $this->belongsTo(Prioridad::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function direccion()
    {
        return $this->belongsTo(Direccion::class);
    }

    public function tipo()
    {
        return $this->belongsTo(Tipoticket::class);
    }

}
