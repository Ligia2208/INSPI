<?php

namespace App\Models\Inventario;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;
use App\Models\Inventario\Edificio;
use App\Models\Inventario\Sector;
use App\Models\Inventario\Clase;
use App\Models\Inventario\Marca;
use App\Models\Inventario\Origen;
use App\Models\Inventario\Estado;

class Articulo extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Articulos';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'inventario';
    public $table = 'articulos';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Articulo ha sido {$eventName}";
    }

    public function edificio()
    {
        return $this->belongsTo(Edificio::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }
    
    public function clase()
    {
        return $this->belongsTo(Clase::class);
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function origen()
    {
        return $this->belongsTo(Origen::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function custodio()
    {
        return $this->belongsTo(User::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

}
