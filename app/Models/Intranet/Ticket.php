<?php

namespace App\Models\Intranet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;

class Ticket extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Tickets';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'intranet';
    public $table = 'intic_tickets';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Ticket ha sido {$eventName}";
    }

    public function estadoticket()
    {
        return $this->belongsTo(Estadoticket::class);
    }
    public function tecnico()
    {
        return $this->belongsTo(Tecnico::class);
    }


}
