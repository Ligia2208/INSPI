<?php
namespace App\Models\CentrosReferencia;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;


class Analiticap extends Model
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

    public function unidades()
    {
        return $this->belongsTo(Unidades::class);
    }

    public function clase()
    {
        return $this->belongsTo(Clase::class);
    }

    public function antibiogramamico()
    {
        return $this->belongsTo(Tipoparametros::class);
    }

    public function deteccionunomico()
    {
        return $this->belongsTo(Tipoparametros::class);
    }

    public function detecciondosmico()
    {
        return $this->belongsTo(Tipoparametros::class);
    }
    public function detecciontresmico()
    {
        return $this->belongsTo(Tipoparametros::class);
    }
    public function deteccioncuatromico()
    {
        return $this->belongsTo(Tipoparametros::class);
    }

    public function fungicounomico()
    {
        return $this->belongsTo(Tipoparametros::class);
    }

    public function fungicodosmico()
    {
        return $this->belongsTo(Tipoparametros::class);
    }

    public function fungicotresmico()
    {
        return $this->belongsTo(Tipoparametros::class);
    }

    public function fungicocuatromico()
    {
        return $this->belongsTo(Tipoparametros::class);
    }

    public function fungicocincomico()
    {
        return $this->belongsTo(Tipoparametros::class);
    }

    public function fungicseismico()
    {
        return $this->belongsTo(Tipoparametros::class);
    }

    public function fungicsietemico()
    {
        return $this->belongsTo(Tipoparametros::class);
    }

    public function antibioticopsunobacte()
    {
        return $this->belongsTo(Tipoparametros::class);
    }

    public function antibioticopsdosbacte()
    {
        return $this->belongsTo(Tipoparametros::class);
    }

    public function antibioticopstresbacte()
    {
        return $this->belongsTo(Tipoparametros::class);
    }

    public function antibioticopscuatrobacte()
    {
        return $this->belongsTo(Tipoparametros::class);
    }

    public function antibioticopscincobacte()
    {
        return $this->belongsTo(Tipoparametros::class);
    }

    public function antibioticopsseisbacte()
    {
        return $this->belongsTo(Tipoparametros::class);
    }

    public function antibioticomdunobacte()
    {
        return $this->belongsTo(Tipoparametros::class);
    }

    public function antibioticomddosbacte()
    {
        return $this->belongsTo(Tipoparametros::class);
    }

    public function antibioticomdtresbacte()
    {
        return $this->belongsTo(Tipoparametros::class);
    }

    public function antibioticomdcuatrobacte()
    {
        return $this->belongsTo(Tipoparametros::class);
    }

    public function estado_muestra()
    {
        return $this->belongsTo(Estadomuestra::class);
    }

    public function tipo_rechazo_muestra()
    {
        return $this->belongsTo(Tiporechazomuestra::class);
    }

}
