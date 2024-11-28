<?php

namespace App\Models\Inventario;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class Marca extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Marca';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'inventario';
    public $table = 'marcas';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Una Marca ha sido {$eventName}";
    }

}
