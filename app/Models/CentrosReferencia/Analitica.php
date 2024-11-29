 <?php
namespace App\Models\CentrosReferencia;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;


class Analitica extends Model
{
    use LogsActivity;

    protected $guarded = [];

    //Logs
    protected static $logName = 'Analitica de muestras';
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected $connection = 'crns';
    public $table = 'analiticas';

    public function getDescriptionForEvent(string $eventName)
    {
        return "Un Reporte de resultados ha sido {$eventName}";
    }

    public function preanalitica()
    {
        return $this->belongsTo(Preanalitica::class);
    }

    public function sedes()
    {
        return $this->belongsTo(Sede::class);
    }

    public function crns()
    {
        return $this->belongsTo(Crn::class);
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function tecnica()
    {
        return $this->belongsTo(Tecnica::class);
    }

    public function muestra()
    {
        return $this->belongsTo(Muestra::class);
    }

    public function resultado()
    {
        return $this->belongsTo(Reporte::class);
    }

    public function usuariot()
    {
        return $this->belongsTo(User::class);
    }

    public function usuarior()
    {
        return $this->belongsTo(User::class);
    }

    public function usuariop()
    {
        return $this->belongsTo(User::class);
    }

}
