<?php

namespace App\Models\Plataformas;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Plataformas\Especie;
use App\Models\Plataformas\Sexo_especie;

class Especimen extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Especimen';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false; 
    protected $connection = 'plataformas';
    public $table = 'especimenes';
    

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Especimen ha sido {$eventName}";
    }

    public function especie()
    {
        return $this->belongsTo(Especie::class);
    }

    public function sexo()
    {
        return $this->belongsTo(Sexo_especie::class);
    }

}
