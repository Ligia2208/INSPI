<?php

namespace App\Imports;

use App\Models\CentrosReferencia\Pacientetemp;
use App\Models\CentrosReferencia\Paciente;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PHPMailer\PHPMailer\Exception;
use Libraries\Services\Complement;
use Datetime;

class PacientesImport implements ToModel
{
    private $numRows;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
            ++$this->numRows;

            $booleannuevo = Paciente::where('estado','=','A')->where('identidad','=',$row[2])->count();
            $stu = new Pacientetemp();

            $porciones = explode("/", $row[0]);
            $fecnew = $porciones[2].'-'.$porciones[1].'-'.$porciones[0];
            $objeto_DateTime = date($fecnew);

            $stu->fecha_toma = $objeto_DateTime;
            if($row[1]==""){
                $stu->hora_toma='00:00:00';
            }
            else{
                $stu->hora_toma = $row[1];
            }
            $stu->identidad = $row[2];
            $stu->apellidos = $row[3];
            $stu->nombres = $row[4];

            if($row[5]==""){
                $stu->fechanacimiento = date("Y-m-d");
            }
            else{
                $porciones = explode("/", $row[5]);
                $fecnew = $porciones[2].'-'.$porciones[1].'-'.$porciones[0];
                $objeto_DateTime = date($fecnew);
                $stu->fechanacimiento = $objeto_DateTime;
            }
            if($booleannuevo>0){
                $stu->id_paciente = Paciente::where('estado','=','A')->where('identidad','=',$row[2])->pluck('id')->first();
            }
            else{
                $stu->id_paciente = 0;
            }
            if($row[6]==""){
                $stu->sexo = 'F';
            }
            else{
                $stu->sexo = $row[6];
            }

            if($row[7]==""){
                $stu->direccion = '';
            }
            else{
                $stu->direccion = $row[7];
            }

            if($row[8]==""){
                $stu->telefono = '';
            }
            else{
                $stu->telefono = $row[8];
            }

            $stu->save();

            return $stu;

    }

    public function rules(): array
    {
        return [
            'identidad' => 'required|max:20',
            'apellidos' => 'required|max:75',
            'nombres' => 'required|max:75',
            'fecha_toma' => 'required|max:10',
            'hora_toma' => 'required|max:10',
            'fechanacimiento' => 'required|max:10',
            'id_paciente' => 'required|numeric',
            'sexo' => 'sometimes|max:1',
            'direccion' => 'sometimes|max:175',
            'telefono' => 'sometimes|max:15',
        ];
    }

    public function getRowCount(): int
    {
        return $this->numRows;
    }
}
