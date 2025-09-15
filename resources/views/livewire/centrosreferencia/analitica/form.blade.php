<div class="col-xl-12" x-data="app()">

    @section('head')
        <link rel="stylesheet" href="{{ asset('assets/plugins/custom/bfi/bfi.css') }}">
    @endsection

    <!--begin::Card-->
    <div class="card card-custom card-sticky" id="kt_page_sticky_card" >
        <div class="card-body">
            <!--begin::Form-->
            <form class="form" wire:submit.prevent="{{ $method }}" >
                <div class="row">
                    <div class="col-xl-12">
                        <div class="my-5">
                            @include('component.error-list')
                            <a href="{{ route('analitica.index') }}" class="navi-link py-4 {{ active('user.index') }}">

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i aria-hidden="true" class="ki ki-bold-close icon-lg"></i>
                                </button>
                            </a>
                            <h3 class="text-dark font-weight-bold mb-10">Información general</h3>

                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label>Institución Salud<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group input-group-solid">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                            </div>
                                            <input
                                                type="text"
                                                required disabled
                                                class="form-control form-control-solid"
                                                value = "{{ $Analiticas->preanalitica->instituciones->descripcion }}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-7">
                                    <label>Clasificación<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group input-group-solid">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                            </div>
                                            <input
                                                type="text"
                                                required disabled
                                                class="form-control form-control-solid"
                                                value = "{{ $Analiticas->preanalitica->instituciones->clasificacion->descripcion }} - {{ $Analiticas->preanalitica->instituciones->tipologia->descripcion }} - {{ $Analiticas->preanalitica->instituciones->nivel->descripcion }} ( {{ $Analiticas->preanalitica->instituciones->provincia->descripcion }}-{{ $Analiticas->preanalitica->instituciones->canton->descripcion }})" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label>Fecha Recepción<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input
                                            type="date"
                                            value="{{ $preanalitica->fecha_recepcion }}"
                                            class="start_date form-control form-control-solid @error('Analiticas.fecha_recepcion') is-invalid @enderror"
                                            placeholder="Seleccione una fecha" disabled
                                        />
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Sede<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Analiticas.sedes_id"
                                            wire:model="selectedSede"
                                            class="form-control selectpicker form-control-solid @error('Analiticas.sedes_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required disabled>
                                            <option value="">Selecciona una Sede</option>
                                            @foreach ($sedes as $objSed)
                                                <option data-subtext="" value="{{ $objSed->id }}">{{ $objSed->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Centro de Referencia - Laboratorio<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Analiticas.crns_id"
                                            wire:model.live="selectedCrn"
                                            class="form-control selectpicker form-control-solid @error('Analiticas.crns_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required disabled>
                                            <option value="">Selecciona un CRN</option>
                                            @if(!is_null($crns))
                                            @foreach ($crns as $objCrn)
                                                <option data-subtext="" value="{{ $objCrn->id }}">{{ $objCrn->descripcion }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Código: <span class="text-danger">{{ $Analiticas->codigo_calidad }}</span></label>
                                    @if ($preanalitica->archivo != null)
                                    <a target="_blank" class="btn btn-success font-weight-bold mr-2 dropdown-item" href="{{ Storage::url($preanalitica->archivo) }}"><i class="fas fa-download mr-2"></i> Descargar Ficha</a>
                                    @else
                                    <a target="_blank" class="btn btn-info font-weight-bold mr-2 dropdown-item" href=""><i class="fas fa-download mr-2"></i> No existe ficha digital</a>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label>Evento<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Analiticas.evento_id"
                                            class="form-control selectpicker form-control-solid @error('Analiticas.evento_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required
                                            @if($Analiticas->codigo_externo != '' && $Analiticas->adicional == 2)
                                                enabled
                                            @else
                                                disabled
                                            @endif>
                                            <option value="">Selecciona un Evento</option>
                                            @if(!is_null($eventos))
                                            @foreach ($eventos as $objEvento)
                                                <option data-subtext="" value="{{ $objEvento->id }}">{{ $objEvento->simplificado }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Clase Muestra<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Analiticas.clase_id"
                                            class="form-control selectpicker form-control-solid @error('Analiticas.clase_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required disabled>
                                            <option value="">Selecciona un Clase</option>
                                            @foreach ($clases as $objClase)
                                                <option data-subtext="" value="{{ $objClase->id }}">{{ $objClase->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Tipo de Muestra<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Analiticas.muestra_id"
                                            class="form-control selectpicker form-control-solid @error('Analiticas.evento_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required disabled>
                                            <option value="">Selecciona un Evento</option>
                                            @foreach ($muestras as $objMuestra)
                                                <option data-subtext="" value="{{ $objMuestra->id }}">{{ $objMuestra->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="text-black"><b>Calidad Muestra</b><span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Analiticas.estado_muestra_id"
                                            class="form-control selectpicker form-control-solid @error('Analiticas.estado_muestra_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required >
                                            <option value="">Selecciona estado muestra</option>
                                            @foreach ($estados as $objEstados)
                                                <option data-subtext="" value="{{ $objEstados->id }}">
                                                    {{ $objEstados->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label>Cédula<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            type="text"
                                            required disabled
                                            class="form-control form-control-solid"
                                            value = {{ $preanalitica->paciente->identidad }} />
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Nombres Paciente<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            type="text"
                                            required disabled
                                            class="form-control form-control-solid"
                                            value = "{{ $preanalitica->paciente->apellidos }} {{ $preanalitica->paciente->nombres }}">
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Sexo<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            type="text"
                                            required disabled
                                            class="form-control form-control-solid"
                                            value = {{ $preanalitica->paciente->sexo->descripcion }}>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Fecha Nacimiento<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input
                                            type="date"
                                            value="{{ $preanalitica->paciente->fechanacimiento }}"
                                            class="start_date form-control form-control-solid @error('Analiticas.fecha_atencion') is-invalid @enderror"
                                            placeholder="Seleccione una fecha" disabled
                                        />
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Edad<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            type="text"
                                            required disabled
                                            class="form-control form-control-solid"
                                            <?php
                                            $tiempo = strtotime($preanalitica->paciente->fechanacimiento);
                                            $ahora = time();
                                            $tanios = ($ahora-$tiempo)/(60*60*24*365.25);
                                            $tmeses = ($ahora-$tiempo)/(60*60*24*30.44);
                                            $tdias = ($ahora-$tiempo)/(60*60*24);
                                            $anios = floor($tanios);
                                            $meses = floor($tmeses) - $anios*12;
                                            $mdias = floor($tdias) - $anios*365.25 - $meses*30.44;
                                            $dias = floor($mdias);
                                            ?>
                                            value = "{{ $anios }} años {{ $meses }} meses {{  $dias }} días" >
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-1">
                                    <label>Embarazo<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            type="text"
                                            required disabled
                                            class="form-control form-control-solid"
                                            @if($preanalitica->embarazo=='N')
                                            value = "No"
                                            @else
                                            value = "Si"
                                            @endif>
                                    </div>
                                </div>
                                <div class="form-group col-md-1">
                                    <label>Gestacion<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            type="text"
                                            required disabled
                                            class="form-control form-control-solid"
                                            @if($preanalitica->gestacion>0)
                                            value = {{ $preanalitica->gestacion }}
                                            @else
                                            value = "0"
                                            @endif>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Probable infección<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            type="text"
                                            required disabled
                                            class="form-control form-control-solid"
                                            value = "{{ $Analiticas->probable_infeccion }}" >
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Fecha inicio sintomas<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input
                                            type="date"
                                            class="start_date form-control form-control-solid"
                                            value={{ $preanalitica->fecha_sintomas }} disabled
                                        />
                                    </div>
                                </div>
                                <div class="form-group col-md-1">
                                    <label>Dias Evolución<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            type="text"
                                            required disabled
                                            class="form-control form-control-solid"
                                            value = "{{ $Analiticas->evolucion }}" >
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Médico Notifica<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            type="text"
                                            required disabled
                                            class="form-control form-control-solid"
                                            value = "{{ $preanalitica->quien_notifica }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                @if($Analiticas->evento_id==141)
                                <div class="form-group col-md-1">
                                    <label>Laboratorio<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            type="text"
                                            required disabled
                                            class="form-control form-control-solid"
                                            @if($preanalitica->laboratorio=='N')
                                            value = "No"
                                            @else
                                            value = "Si"
                                            @endif>
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Nombre Laboratorio<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            type="text"
                                            required disabled
                                            class="form-control form-control-solid"
                                            value = {{ $preanalitica->nombre_laboratorio }} >
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Año - Período<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Analiticas.anio_registro"
                                            type="text"
                                            required disabled
                                            class="form-control form-control-solid @error('Analiticas.anio_registro') is-invalid @enderror"
                                            placeholder="Ej: 4A39982" />
                                    </div>
                                    @error('Analiticas.anio_registro')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Código Muestra<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            type="text"
                                            required disabled
                                            value={{ str_pad($Analiticas->codigo_muestra, 6, "0", STR_PAD_LEFT) }}
                                            class="form-control form-control-solid @error('Analiticas.codigo_muestra') is-invalid @enderror"
                                            placeholder="Ej: 4A39982" />
                                    </div>
                                    @error('Analiticas.codigo_muestra')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-1">
                                    <label>Secuencia<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            type="text"
                                            required disabled
                                            value={{ str_pad($Analiticas->codigo_secuencial, 2, "0", STR_PAD_LEFT) }}
                                            class="form-control form-control-solid @error('Analiticas.codigo_secuencial') is-invalid @enderror"
                                            placeholder="Ej: 4A39982" />
                                    </div>
                                    @error('Analiticas.codigo_secuencial')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Fecha toma de muestra<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Analiticas.fecha_toma"
                                            type="date"
                                            class="start_date form-control form-control-solid @error('Analiticas.fecha_toma') is-invalid @enderror"
                                            placeholder="Seleccione una fecha" disabled
                                        />
                                    </div>
                                </div>
                                <div class="form-group col-md-1">
                                    <label>Hora toma<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-timer"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Analiticas.hora_toma"
                                            type="time"
                                            class="start_date form-control form-control-solid @error('Analiticas.hora_toma') is-invalid @enderror"
                                            placeholder="Seleccione una fecha" disabled
                                        />
                                    </div>
                                </div>
                                @else
                                <div class="form-group col-md-1">
                                    <label>Laboratorio<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            type="text"
                                            required disabled
                                            class="form-control form-control-solid"
                                            @if($preanalitica->laboratorio=='N')
                                            value = "No"
                                            @else
                                            value = "Si"
                                            @endif>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Nombre Laboratorio<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            type="text"
                                            required disabled
                                            class="form-control form-control-solid"
                                            value = {{ $preanalitica->nombre_laboratorio }} >
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Año - Período<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Analiticas.anio_registro"
                                            type="text"
                                            required disabled
                                            class="form-control form-control-solid @error('Analiticas.anio_registro') is-invalid @enderror"
                                            placeholder="Ej: 4A39982" />
                                    </div>
                                    @error('Analiticas.anio_registro')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Código Muestra<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            type="text"
                                            required disabled
                                            value={{ str_pad($Analiticas->codigo_muestra, 6, "0", STR_PAD_LEFT) }}
                                            class="form-control form-control-solid @error('Analiticas.codigo_muestra') is-invalid @enderror"
                                            placeholder="Ej: 4A39982" />
                                    </div>
                                    @error('Analiticas.codigo_muestra')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-1">
                                    <label>Secuencia<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            type="text"
                                            required disabled
                                            value={{ str_pad($Analiticas->codigo_secuencial, 2, "0", STR_PAD_LEFT) }}
                                            class="form-control form-control-solid @error('Analiticas.codigo_secuencial') is-invalid @enderror"
                                            placeholder="Ej: 4A39982" />
                                    </div>
                                    @error('Analiticas.codigo_secuencial')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Fecha toma de muestra<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Analiticas.fecha_toma"
                                            type="date"
                                            class="start_date form-control form-control-solid @error('Analiticas.fecha_toma') is-invalid @enderror"
                                            placeholder="Seleccione una fecha" disabled
                                        />
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label>Fecha Atención<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input
                                            type="date"
                                            value="{{ $preanalitica->fecha_atencion }}"
                                            class="start_date form-control form-control-solid @error('Analiticas.fecha_atencion') is-invalid @enderror"
                                            placeholder="Seleccione una fecha" disabled
                                        />
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="text-black"><b>Código Externo</b><span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Analiticas.codigo_externo"
                                            type="text"
                                            required
                                            class="form-control form-control-solid @error('Analiticas.codigo_externo') is-invalid @enderror"
                                            placeholder="Ej: 4A39982" />
                                    </div>
                                    @error('Analiticas.codigo_externo')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="text-black"><b>Llegada a CRN-Lab.</b><span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Analiticas.fecha_llegada_lab"
                                            type="date" required
                                            class="start_date form-control form-control-solid @error('Analiticas.fecha_llegada_lab') is-invalid @enderror"
                                            placeholder="Seleccione una fecha"
                                        />
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="text-black"><b>Fecha Procesamiento</b><span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Analiticas.fecha_procesamiento"
                                            type="date" required
                                            class="start_date form-control form-control-solid @error('Analiticas.fecha_procesamiento') is-invalid @enderror"
                                            placeholder="Seleccione una fecha"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label class="text-black"><b>Técnica Aplicada</b><span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            id="selecttecnica"
                                            wire:model.defer="Analiticas.tecnica_id"
                                            class="form-control selectpicker form-control-solid @error('Analiticas.tecnica_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="0">Selecciona una Técnica</option>
                                            @if(!is_null($tecnicas))
                                            @foreach ($tecnicas as $objTecn)
                                                <option data-subtext="" value="{{ $objTecn->id }}">{{ $objTecn->descripcion }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="text-black"><b>Resultado</b><span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Analiticas.resultado_id"
                                            class="form-control selectpicker form-control-solid @error('Analiticas.resultado_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="0">Selecciona un Resultado</option>
                                            @if(!is_null($reportes))
                                            @foreach ($reportes as $objRep)
                                                <option data-subtext="" value="{{ $objRep->id }}">{{ $objRep->descripcion }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @error('Analiticas.resultado_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                            </div>
                            @if($Analiticas->crns_id==3)
                                <ul class="nav nav-tabs nav-justified" role="tablist">
                                    <li role="presentation" class="active" wire:ignore>
                                        <a class="btn btn-default" href="#tab-1" aria-controls="#tab-1" role="tab" data-toggle="tab">Agente Identificado</a>
                                    </li>
                                    <li role="presentation" wire:ignore>
                                        <a class="btn btn-default" href="#tab-2" aria-controls="#tab-2" role="tab" data-toggle="tab">Pruebas de Susceptibilidad (Método difusión: Kirby Bauer)</a>
                                    </li>
                                    <li role="presentation" wire:ignore>
                                        <a class="btn btn-default" href="#tab-3" aria-controls="#tab-3" role="tab" data-toggle="tab">Método de Dilución (Concentración mínima inhibitoria)</a>
                                    </li>
                                </ul>
                                @include('component.error-list')
                                <div class="tab-content mt-5">
                                    <div role="tabpanel" class="tab-pane active" id="tab-1" wire:ignore.self>
                                        <div class="col-md-12 col-md-offset-2">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label class="text-black"><b>Agente identificado</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.identificado"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.identificado') is-invalid @enderror"
                                                            placeholder="Ej: Otra bacteria" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="text-black"><b>Observación</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.recomendacion_bacterio"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.recomendacion_bacterio') is-invalid @enderror"
                                                            placeholder="Ej: Realizar pruebas adicionales condicionadas" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="tab-2" wire:ignore.self>
                                        <div class="col-md-12 col-md-offset-2">
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label class="text-black"><b>Antibiótico</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.antibioticopsunobacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.antibioticopsunobacte_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona un Antibiotico</option>
                                                            @foreach ($bacteantibioticokb as $objBacAnti)
                                                                <option data-subtext="" value="{{ $objBacAnti->id }}">{{ $objBacAnti->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-1">
                                                    <label class="text-black"><b>HALO (mm.)</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.halopsuno_bacte"
                                                            type="number"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.halopsuno_bacte') is-invalid @enderror"
                                                            placeholder="Ej: Valor CIM" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-black"><b>Interpretación</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.escalapsunobacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.escalapsunobacte_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una escala</option>
                                                            <option value="1">Sensible</option>
                                                            <option value="2">Intermedio</option>
                                                            <option value="3">Resistente</option>
                                                            <option value="4">Sensibilidad disminuida a penicilina</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label class="text-black"><b>Antibiótico</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.antibioticopsdosbacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.antibioticopsdosbacte_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona un Antibiotico</option>
                                                            @foreach ($bacteantibioticokb as $objBacAnti)
                                                                <option data-subtext="" value="{{ $objBacAnti->id }}">{{ $objBacAnti->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-1">
                                                    <label class="text-black"><b>HALO (mm.)</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.halopsdos_bacte"
                                                            type="number"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.halopsdos_bacte') is-invalid @enderror"
                                                            placeholder="Ej: Valor CIM" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-black"><b>Interpretación</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.escalapsdosbacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.escalapsdosbacte_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una escala</option>
                                                            <option value="1">Sensible</option>
                                                            <option value="2">Intermedio</option>
                                                            <option value="3">Resistente</option>
                                                            <option value="4">Sensibilidad disminuida a penicilina</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label class="text-black"><b>Antibiótico</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.antibioticopstresbacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.antibioticopstresbacte_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona un Antibiotico</option>
                                                            @foreach ($bacteantibioticokb as $objBacAnti)
                                                                <option data-subtext="" value="{{ $objBacAnti->id }}">{{ $objBacAnti->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-1">
                                                    <label class="text-black"><b>HALO (mm.)</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.halopstres_bacte"
                                                            type="number"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.halopstres_bacte') is-invalid @enderror"
                                                            placeholder="Ej: Valor CIM" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-black"><b>Interpretación</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.escalapstresbacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.escalapstresbacte_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una escala</option>
                                                            <option value="1">Sensible</option>
                                                            <option value="2">Intermedio</option>
                                                            <option value="3">Resistente</option>
                                                            <option value="4">Sensibilidad disminuida a penicilina</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label class="text-black"><b>Antibiótico</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.antibioticopscuatrobacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.antibioticopscuatrobacte_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona un Antibiotico</option>
                                                            @foreach ($bacteantibioticokb as $objBacAnti)
                                                                <option data-subtext="" value="{{ $objBacAnti->id }}">{{ $objBacAnti->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-1">
                                                    <label class="text-black"><b>HALO (mm.)</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.halopscuatro_bacte"
                                                            type="number"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.halopscuatro_bacte') is-invalid @enderror"
                                                            placeholder="Ej: Valor CIM" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-black"><b>Interpretación</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.escalapscuatrobacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.escalapscuatrobacte_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una escala</option>
                                                            <option value="1">Sensible</option>
                                                            <option value="2">Intermedio</option>
                                                            <option value="3">Resistente</option>
                                                            <option value="4">Sensibilidad disminuida a penicilina</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label class="text-black"><b>Antibiótico</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.antibioticopscincobacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.antibioticopscincobacte_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona un Antibiotico</option>
                                                            @foreach ($bacteantibioticokb as $objBacAnti)
                                                                <option data-subtext="" value="{{ $objBacAnti->id }}">{{ $objBacAnti->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-1">
                                                    <label class="text-black"><b>HALO (mm.)</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.halopscinco_bacte"
                                                            type="number"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.halopscinco_bacte') is-invalid @enderror"
                                                            placeholder="Ej: Valor CIM" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-black"><b>Interpretación</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.escalapscincobacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.escalapscincobacte_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una escala</option>
                                                            <option value="1">Sensible</option>
                                                            <option value="2">Intermedio</option>
                                                            <option value="3">Resistente</option>
                                                            <option value="4">Sensibilidad disminuida a penicilina</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label class="text-black"><b>Antibiótico</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.antibioticopsseisbacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.antibioticopsseisbacte_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona un Antibiotico</option>
                                                            @foreach ($bacteantibioticokb as $objBacAnti)
                                                                <option data-subtext="" value="{{ $objBacAnti->id }}">{{ $objBacAnti->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-1">
                                                    <label class="text-black"><b>HALO (mm.)</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.halopsseis_bacte"
                                                            type="number"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.halopsseis_bacte') is-invalid @enderror"
                                                            placeholder="Ej: Valor CIM" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-black"><b>Interpretación</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.escalapsseisbacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.escalapsseisbacte_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una escala</option>
                                                            <option value="1">Sensible</option>
                                                            <option value="2">Intermedio</option>
                                                            <option value="3">Resistente</option>
                                                            <option value="4">Sensibilidad disminuida a penicilina</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="tab-3" wire:ignore.self>
                                        <div class="col-md-12 col-md-offset-2">
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label class="text-black"><b>Antibiótico</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.antibioticomdunobacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.antibioticomdunobacte_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona un Antibiotico</option>
                                                            @foreach ($bacteantibioticomic as $objBacAnti)
                                                                <option data-subtext="" value="{{ $objBacAnti->id }}">{{ $objBacAnti->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-1">
                                                    <label class="text-black"><b>CIM (mm.)</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.cimmduno_bacte"
                                                            type="number"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.cimmduno_bacte') is-invalid @enderror"
                                                            placeholder="Ej: Valor CIM" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-black"><b>Interpretación</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.escalamdunobacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.escalamdunobacte_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una escala</option>
                                                            <option value="1">Sensible</option>
                                                            <option value="2">Intermedio</option>
                                                            <option value="3">Resistente</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label class="text-black"><b>Antibiótico</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.antibioticomddosbacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.antibioticomddosbacte_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona un Antibiotico</option>
                                                            @foreach ($bacteantibioticomic as $objBacAnti)
                                                                <option data-subtext="" value="{{ $objBacAnti->id }}">{{ $objBacAnti->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-1">
                                                    <label class="text-black"><b>CIM (mm.)</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.cimmddos_bacte"
                                                            type="number"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.cimmddos_bacte') is-invalid @enderror"
                                                            placeholder="Ej: Valor CIM" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-black"><b>Interpretación</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.escalamddosbacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.escalamddosbacte_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una escala</option>
                                                            <option value="1">Sensible</option>
                                                            <option value="2">Intermedio</option>
                                                            <option value="3">Resistente</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label class="text-black"><b>Antibiótico</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.antibioticomdtresbacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.antibioticomdtresbacte_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona un Antibiotico</option>
                                                            @foreach ($bacteantibioticomic as $objBacAnti)
                                                                <option data-subtext="" value="{{ $objBacAnti->id }}">{{ $objBacAnti->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-1">
                                                    <label class="text-black"><b>CIM (mm.)</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.cimmdtres_bacte"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.cimmdtres_bacte') is-invalid @enderror"
                                                            placeholder="Ej: Valor CIM" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-black"><b>Interpretación</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.escalamdtresbacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.escalamdtresbacte_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una escala</option>
                                                            <option value="1">Sensible</option>
                                                            <option value="2">Intermedio</option>
                                                            <option value="3">Resistente</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label class="text-black"><b>Antibiótico</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.antibioticomdcuatrobacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.antibioticomdcuatrobacte_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona un Antibiotico</option>
                                                            @foreach ($bacteantibioticomic as $objBacAnti)
                                                                <option data-subtext="" value="{{ $objBacAnti->id }}">{{ $objBacAnti->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-1">
                                                    <label class="text-black"><b>CIM (mm.)</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.cimmdcuatro_bacte"
                                                            type="number"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.cimmdcuatro_bacte') is-invalid @enderror"
                                                            placeholder="Ej: Valor CIM" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-black"><b>Interpretación</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.escalamdcuatrobacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.escalamdcuatrobacte_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una escala</option>
                                                            <option value="1">Sensible</option>
                                                            <option value="2">Intermedio</option>
                                                            <option value="3">Resistente</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($Analiticas->crns_id==12)
                                <ul class="nav nav-tabs nav-justified" role="tablist">
                                    <li role="presentation" class="active" wire:ignore>
                                        <a class="btn btn-default" href="#tab-1" aria-controls="#tab-1" role="tab" data-toggle="tab">Resultado Cuantitativo</a>
                                    </li>
                                    <li role="presentation" wire:ignore>
                                        <a class="btn btn-default" href="#tab-2" aria-controls="#tab-2" role="tab" data-toggle="tab">Medicamentos</a>
                                    </li>
                                </ul>
                                @include('component.error-list')
                                <div class="tab-content mt-5">
                                    <div role="tabpanel" class="tab-pane active" id="tab-1" wire:ignore.self>
                                        <div class="col-md-12 col-md-offset-2">
                                            <div class="form-row">
                                                <div class="form-group col-md-2">
                                                    <label class="text-black"><b>Carga Viral</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.carga_viral"
                                                            type="numeric"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.carga_viral') is-invalid @enderror"
                                                            placeholder="Ej: 1287" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label class="text-black"><b>Unidades</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una unidad</option>
                                                            @foreach ($unidades as $objUni)
                                                                <option data-subtext="" value="{{ $objUni->id }}">{{ $objUni->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-8">
                                                    <label class="text-black"><b>Observación</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.recomendacion_inmuno"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.recomendacion_inmuno') is-invalid @enderror"
                                                            placeholder="Ej: Realizar pruebas adicionales condicionadas" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="tab-2" wire:ignore.self>
                                        <div class="form-row">
                                            <div class="col-md-6 col-md-offset-2">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12" align="center">
                                                        <label class="text-black"><b> - PI - </b></label>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="text-black"><b>Nombre Genérico</b></label>
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentopi as $objUni)
                                                            @if($objUni->id==57)
                                                            <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="text-black"><b>Interpretación</b></label>
                                                        <select
                                                            wire:model.defer="Analiticas.pi01_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.pi01_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentopi as $objUni)
                                                                @if($objUni->id==58)
                                                                <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.pi02_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.pi02_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentopi as $objUni)
                                                                @if($objUni->id==59)
                                                                <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.pi03_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.pi03_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentopi as $objUni)
                                                                @if($objUni->id==60)
                                                                <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.pi04_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.pi04_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentopi as $objUni)
                                                                @if($objUni->id==61)
                                                                <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.pi05_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.pi05_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentopi as $objUni)
                                                                @if($objUni->id==62)
                                                                <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.pi06_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.pi06_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentopi as $objUni)
                                                                @if($objUni->id==63)
                                                                <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.pi07_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.pi07_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentopi as $objUni)
                                                                @if($objUni->id==64)
                                                                <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.pi08_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.pi08_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-md-offset-2">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12" align="center">
                                                        <label class="text-black"><b> - NRTI - </b></label>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="text-black"><b>Nombre Genérico</b></label>
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentonrti as $objUni)
                                                            @if($objUni->id==65)
                                                            <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="text-black"><b>Interpretación</b></label>
                                                        <select
                                                            wire:model.defer="Analiticas.nrti01_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.nrti01_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentonrti as $objUni)
                                                            @if($objUni->id==66)
                                                            <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.nrti02_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.nrti02_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentonrti as $objUni)
                                                            @if($objUni->id==67)
                                                            <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.nrti03_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.nrti03_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentonrti as $objUni)
                                                            @if($objUni->id==68)
                                                            <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.nrti04_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.nrti04_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentonrti as $objUni)
                                                            @if($objUni->id==69)
                                                            <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.nrti05_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.nrti05_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentonrti as $objUni)
                                                            @if($objUni->id==70)
                                                            <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.nrti06_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.nrti06_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentonrti as $objUni)
                                                            @if($objUni->id==71)
                                                            <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.nrti07_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.nrti07_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-row">
                                            <div class="col-md-6 col-md-offset-2">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12" align="center">
                                                        <label class="text-black"><b> - NNRTI - </b></label>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="text-black"><b>Nombre Genérico</b></label>
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentonnrti as $objUni)
                                                            @if($objUni->id==72)
                                                            <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="text-black"><b>Interpretación</b></label>
                                                        <select
                                                            wire:model.defer="Analiticas.nnrti01_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.nnrti01_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentonnrti as $objUni)
                                                            @if($objUni->id==73)
                                                            <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.nnrti02_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.nnrti02_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentonnrti as $objUni)
                                                            @if($objUni->id==74)
                                                            <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.nnrti03_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.nnrti03_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentonnrti as $objUni)
                                                            @if($objUni->id==75)
                                                            <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.nnrti04_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.nnrti04_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentonnrti as $objUni)
                                                            @if($objUni->id==76)
                                                            <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.nnrti05_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.nnrti05_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentonnrti as $objUni)
                                                            @if($objUni->id==77)
                                                            <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.nnrti06_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.nnrti06_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-md-offset-2">
                                                <div class="form-row">
                                                    <div class="form-group col-md-12" align="center">
                                                        <label class="text-black"><b> - INI - </b></label>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="text-black"><b>Nombre Genérico</b></label>
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentoini as $objUni)
                                                            @if($objUni->id==78)
                                                            <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="text-black"><b>Interpretación</b></label>
                                                        <select
                                                            wire:model.defer="Analiticas.ini01_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.ini01_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentoini as $objUni)
                                                            @if($objUni->id==79)
                                                            <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.ini02_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.ini02_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentoini as $objUni)
                                                            @if($objUni->id==80)
                                                            <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.ini03_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.ini03_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentoini as $objUni)
                                                            @if($objUni->id==81)
                                                            <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.ini04_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.ini04_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.unidades_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required disabled>
                                                            @foreach ($medicamentoini as $objUni)
                                                            @if($objUni->id==82)
                                                            <option data-subtext="" value="{{ $objUni->id }}" selected="true">{{ $objUni->descripcion }}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <select
                                                            wire:model.defer="Analiticas.ini05_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.ini05_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una interpretación</option>
                                                            <option data-subtext="" value="1">Sensible</option>
                                                            <option data-subtext="" value="2">Resistencia Intermedia</option>
                                                            <option data-subtext="" value="3">Resistencia Alta</option>

                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($Analiticas->crns_id==6)
                                <ul class="nav nav-tabs nav-justified" role="tablist">
                                    <li role="presentation" class="active" wire:ignore>
                                        <a class="btn btn-default" href="#tab-1" aria-controls="#tab-1" role="tab" data-toggle="tab">Agente Identificado</a>
                                    </li>
                                    <li role="presentation" wire:ignore>
                                        <a class="btn btn-default" href="#tab-2" aria-controls="#tab-2" role="tab" data-toggle="tab">Inmunodifusión</a>
                                    </li>
                                    <li role="presentation" wire:ignore>
                                        <a class="btn btn-default" href="#tab-3" aria-controls="#tab-3" role="tab" data-toggle="tab">Antibiograma</a>
                                    </li>
                                </ul>
                                @include('component.error-list')
                                <div class="tab-content mt-5">
                                    <div role="tabpanel" class="tab-pane active" id="tab-1" wire:ignore.self>
                                        <div class="col-md-12 col-md-offset-2">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label class="text-black"><b>Germen aislado</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.germenaislado_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.germenaislado_mico') is-invalid @enderror"
                                                            placeholder="Ej: Germen aislado" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="text-black"><b>Directo KOH</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.directokoh_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.directokoh_mico') is-invalid @enderror"
                                                            placeholder="Ej: Directo KOH" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label class="text-black"><b>Directo placa teñida</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.directoplaca_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.directoplaca_mico') is-invalid @enderror"
                                                            placeholder="Ej: Placa teñida" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="text-black"><b>Tinta china</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.tintachina_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.tintachina_mico') is-invalid @enderror"
                                                            placeholder="Ej: Tinta china" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="tab-2" wire:ignore.self>
                                        <div class="col-md-12 col-md-offset-2">
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label class="text-black"><b>Detección Ac</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.deteccionunomico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.deteccionunomico_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona un Evento</option>
                                                            @foreach ($paradifusion as $objPar)
                                                                <option data-subtext="" value="{{ $objPar->id }}">{{ $objPar->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="text-black"><b>Interpretación</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.interpretaunomico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.interpretaunomico_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una escala</option>
                                                            <option value="1">Positivo</option>
                                                            <option value="2">Negativo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label class="text-black"><b>Detección Ac</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.detecciondosmico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.detecciondosmico_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona un Evento</option>
                                                            @foreach ($paradifusion as $objPar)
                                                                <option data-subtext="" value="{{ $objPar->id }}">{{ $objPar->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="text-black"><b>Interpretación</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.interpretadosmico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.interpretadosmico_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una escala</option>
                                                            <option value="1">Positivo</option>
                                                            <option value="2">Negativo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label class="text-black"><b>Detección Ac</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.detecciontresmico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.detecciontresmico_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona un Evento</option>
                                                            @foreach ($paradifusion as $objPar)
                                                                <option data-subtext="" value="{{ $objPar->id }}">{{ $objPar->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="text-black"><b>Interpretación</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.interpretatresmico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.interpretatresmico_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una escala</option>
                                                            <option value="1">Positivo</option>
                                                            <option value="2">Negativo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label class="text-black"><b>Detección Ac</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.deteccioncuatromico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.deteccioncuatromico_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona un Evento</option>
                                                            @foreach ($paradifusion as $objPar)
                                                                <option data-subtext="" value="{{ $objPar->id }}">{{ $objPar->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label class="text-black"><b>Interpretación</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.interpretacuatromico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.interpretacuatromico_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una escala</option>
                                                            <option value="1">Positivo</option>
                                                            <option value="2">Negativo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane" id="tab-3" wire:ignore.self>
                                        <div class="col-md-12 col-md-offset-2">
                                            <div class="form-row">
                                                <div class="form-group col-md-8">
                                                    <label class="text-black"><b>Antibiograma</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.antibiogramamico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.antibiogramamico_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona un Antibiograma</option>
                                                            @foreach ($parabiograma as $objPar)
                                                                <option data-subtext="" value="{{ $objPar->id }}">{{ $objPar->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label class="text-black"><b>Antifúngico</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.fungicounomico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.fungicounoid_mico') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona un Antimicrobiano</option>
                                                            @foreach ($paramicrobianos as $objPar)
                                                                <option data-subtext="" value="{{ $objPar->id }}">{{ $objPar->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label class="text-black"><b>CIM ug/mL</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.cimuno_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.cimuno_mico') is-invalid @enderror"
                                                            placeholder="Ej: Valor CIM" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-black"><b>Difusión</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.difusionuno_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.cimuno_mico') is-invalid @enderror"
                                                            placeholder="Ej: Valor Difusión" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-black"><b>Interpretación</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.escalaunomico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.escalaid_mico') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una escala</option>
                                                            <option value="1">Sensible</option>
                                                            <option value="2">Intermedio</option>
                                                            <option value="3">Resistente</option>
                                                            <option value="4">ND</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label class="text-black"><b>Antifúngico</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.fungicodosmico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.fungicodosmico_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona un Antimicrobiano</option>
                                                            @foreach ($paramicrobianos as $objPar)
                                                                <option data-subtext="" value="{{ $objPar->id }}">{{ $objPar->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label class="text-black"><b>CIM ug/mL</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.cimdos_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.cimdos_mico') is-invalid @enderror"
                                                            placeholder="Ej: Valor CIM" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-black"><b>Difusión</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.difusiondos_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.cimdos_mico') is-invalid @enderror"
                                                            placeholder="Ej: Valor Difusión" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-black"><b>Interpretación</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.escaladosmico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.escaladosmico_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una escala</option>
                                                            <option value="1">Sensible</option>
                                                            <option value="2">Intermedio</option>
                                                            <option value="3">Resistente</option>
                                                            <option value="4">ND</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label class="text-black"><b>Antifúngico</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.fungicotresmico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.fungicotresmico_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona un Antimicrobiano</option>
                                                            @foreach ($paramicrobianos as $objPar)
                                                                <option data-subtext="" value="{{ $objPar->id }}">{{ $objPar->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label class="text-black"><b>CIM ug/mL</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.cimtres_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.cimtres_mico') is-invalid @enderror"
                                                            placeholder="Ej: Valor CIM" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-black"><b>Difusión</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.difusiontres_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.difusiontres_mico') is-invalid @enderror"
                                                            placeholder="Ej: Valor Difusión" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-black"><b>Interpretación</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.escalatresmico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.escalatresmico_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una escala</option>
                                                            <option value="1">Sensible</option>
                                                            <option value="2">Intermedio</option>
                                                            <option value="3">Resistente</option>
                                                            <option value="4">ND</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label class="text-black"><b>Antifúngico</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.fungicocuatromico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.fungicocuatromico_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona un Antimicrobiano</option>
                                                            @foreach ($paramicrobianos as $objPar)
                                                                <option data-subtext="" value="{{ $objPar->id }}">{{ $objPar->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label class="text-black"><b>CIM ug/mL</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.cimcuatro_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.cimcuatro_mico') is-invalid @enderror"
                                                            placeholder="Ej: Valor CIM" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-black"><b>Difusión</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.difusioncuatro_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.difusioncuatro_mico') is-invalid @enderror"
                                                            placeholder="Ej: Valor Difusión" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-black"><b>Interpretación</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.escalacuatromico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.escalacuatromico_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una escala</option>
                                                            <option value="1">Sensible</option>
                                                            <option value="2">Intermedio</option>
                                                            <option value="3">Resistente</option>
                                                            <option value="4">ND</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label class="text-black"><b>Antifúngico</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.fungicocincomico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.fungicocincomico_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona un Antimicrobiano</option>
                                                            @foreach ($paramicrobianos as $objPar)
                                                                <option data-subtext="" value="{{ $objPar->id }}">{{ $objPar->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label class="text-black"><b>CIM ug/mL</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.cimcinco_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.cimcinco_mico') is-invalid @enderror"
                                                            placeholder="Ej: Valor CIM" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-black"><b>Difusión</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.difusioncinco_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.difusioncinco_mico') is-invalid @enderror"
                                                            placeholder="Ej: Valor Difusión" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-black"><b>Interpretación</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.escalacincomico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.escalacincomico_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una escala</option>
                                                            <option value="1">Sensible</option>
                                                            <option value="2">Intermedio</option>
                                                            <option value="3">Resistente</option>
                                                            <option value="4">ND</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label class="text-black"><b>Antifúngico</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.fungicoseismico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.fungicoseismico_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona un Antimicrobiano</option>
                                                            @foreach ($paramicrobianos as $objPar)
                                                                <option data-subtext="" value="{{ $objPar->id }}">{{ $objPar->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label class="text-black"><b>CIM ug/mL</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.cimseis_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.cimseis_mico') is-invalid @enderror"
                                                            placeholder="Ej: Valor CIM" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-black"><b>Difusión</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.difusionseis_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.difusionseis_mico') is-invalid @enderror"
                                                            placeholder="Ej: Valor Difusión" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-black"><b>Interpretación</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.escalaseismico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.escalaseismico_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una escala</option>
                                                            <option value="1">Sensible</option>
                                                            <option value="2">Intermedio</option>
                                                            <option value="3">Resistente</option>
                                                            <option value="4">ND</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label class="text-black"><b>Antifúngico</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.fungicosietemico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.fungicosietemico_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona un Antimicrobiano</option>
                                                            @foreach ($paramicrobianos as $objPar)
                                                                <option data-subtext="" value="{{ $objPar->id }}">{{ $objPar->descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label class="text-black"><b>CIM ug/mL</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.cimsiete_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.cimsiete_mico') is-invalid @enderror"
                                                            placeholder="Ej: Valor CIM" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-black"><b>Difusión</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticas.difusionsiete_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticas.difusionsiete_mico') is-invalid @enderror"
                                                            placeholder="Ej: Valor Difusión" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-black"><b>Interpretación</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticas.escalasietemico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticas.escalasietemico_id') is-invalid @enderror"
                                                            data-size="7"
                                                            data-live-search="true"
                                                            data-show-subtext="true"
                                                            required>
                                                            <option value="">Selecciona una escala</option>
                                                            <option value="1">Sensible</option>
                                                            <option value="2">Intermedio</option>
                                                            <option value="3">Resistente</option>
                                                            <option value="4">ND</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="text-black"><b>Observación/Investigación:</b></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <textarea
                                            wire:model.defer="Analiticas.observacioninvestiga"
                                            id=""
                                            cols="30"
                                            rows="2"
                                            class="form-control form-control-solid @error('Analiticas.observacioninvestiga') is-invalid @enderror"
                                            placeholder="Ej: Datos relevantes a reportar"
                                            >
                                        </textarea>
                                    </div>
                                </div>
                            @endif

                            <hr>
                            <ul class="nav nav-tabs nav-justified" role="tablist">
                                <li role="presentation" class="active" wire:ignore>
                                    <a class="btn btn-default" href="#tab-11" aria-controls="#tab-11" role="tab" data-toggle="tab">Detalle Resultado</a>
                                </li>
                                <li role="presentation" wire:ignore>
                                    <a class="btn btn-default" href="#tab-12" aria-controls="#tab-12" role="tab" data-toggle="tab">Técnicas adicionales</a>
                                </li>
                            </ul>
                            @include('component.error-list')
                            <div class="tab-content mt-5">
                                <div role="tabpanel" class="tab-pane active" id="tab-11" wire:ignore.self>
                                    <div class="col-md-12 col-md-offset-2">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label class="text-black"><b>Descripción del resultado obtenido</b></label>
                                                <div class="input-group input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-edit"></i>
                                                        </span>
                                                    </div>
                                                    <textarea
                                                        wire:model.defer="Analiticas.descripcion"
                                                        id=""
                                                        cols="30"
                                                        rows="3"
                                                        class="form-control form-control-solid @error('Analiticas.descripcion') is-invalid @enderror"
                                                        placeholder="Ej: Datos relevantes a reportar"
                                                        >
                                                    </textarea>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label class="text-black"><b>Informe Digitalizado </b></label>
                                                <div class="input-group input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fa fa-file"></i>
                                                        </span>
                                                    </div>
                                                    <div class="d-flex jutify-content-start mb-1" >
                                                        @if ($AnaliticaTmp || $Analiticas->archivo)
                                                            <img
                                                                width="65"
                                                                src="{{ asset('assets') }}/media/svg/files/pdf.svg" alt=""
                                                                >
                                                            <span
                                                                x-on:click="removeFile('removeAnalitica', 'AnaliticaTmp')"
                                                                class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow image-remove"
                                                                style="position: inherit;"
                                                                title="Remover Informe">
                                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                                <span
                                                                    wire:loading.class="spinner spinner-primary spinner-sm"
                                                                    wire:target="removeAnalitica"
                                                                    style="position: absolute; left: 81px;">
                                                                </span>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div
                                                        x-data="{ isUploading: false, progress: 0 }"
                                                        x-on:livewire-upload-start="isUploading = true"
                                                        x-on:livewire-upload-finish="isUploading = false"
                                                        x-on:livewire-upload-error="isUploading = false"
                                                        x-on:livewire-upload-progress="progress = $event.detail.progress"
                                                        >
                                                        <div wire:ignore wire:key="Analiticafile">
                                                            <input
                                                                wire:model.defer="AnaliticaTmp"
                                                                class="bfi form-control form-control-solid @error('AnaliticaTmp') is-invalid @enderror"
                                                                type="file"
                                                                accept=".pdf"
                                                                id="AnaliticaTmp"
                                                            />
                                                        </div>
                                                        <!-- Progress Bar -->
                                                        <div x-show="isUploading">
                                                            <progress max="100" x-bind:value="progress"></progress>
                                                        </div>
                                                    </div>
                                                    @error('AnaliticaTmp') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="tab-12" wire:ignore.self>
                                    <div class="col-md-12 col-md-offset-2">
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label class="text-black"><b>Técnica Aplicada</b><span class="text-danger"></span></label>
                                                <div class="input-group input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-list"></i>
                                                        </span>
                                                    </div>
                                                    <select
                                                        wire:model.defer="Analiticas.tecnica_segunda_id"
                                                        class="form-control selectpicker form-control-solid @error('Analiticas.tecnica_segunda_id') is-invalid @enderror"
                                                        data-size="7"
                                                        data-live-search="true"
                                                        data-show-subtext="true"
                                                        required>
                                                        <option value="">Selecciona una Técnica</option>
                                                        @if(!is_null($tecnicas))
                                                        @foreach ($tecnicas as $objTecn)
                                                            <option data-subtext="" value="{{ $objTecn->id }}">{{ $objTecn->descripcion }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="text-black"><b>Resultado</b><span class="text-danger"></span></label>
                                                <div class="input-group input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-list"></i>
                                                        </span>
                                                    </div>
                                                    <select
                                                        wire:model.defer="Analiticas.resultado_segunda_id"
                                                        class="form-control selectpicker form-control-solid @error('Analiticas.resultado_segunda_id') is-invalid @enderror"
                                                        data-size="7"
                                                        data-live-search="true"
                                                        data-show-subtext="true"
                                                        required>
                                                        <option value="">Selecciona un Resultado</option>
                                                        @if(!is_null($reportes))
                                                        @foreach ($reportes as $objRep)
                                                            <option data-subtext="" value="{{ $objRep->id }}">{{ $objRep->descripcion }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="text-black"><b>Agente identificado</b></label>
                                                <div class="input-group input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-edit"></i>
                                                        </span>
                                                    </div>
                                                    <input
                                                        wire:model.defer="Analiticas.identificado_segunda"
                                                        type="text"
                                                        required
                                                        class="form-control form-control-solid @error('Analiticas.identificado_segunda') is-invalid @enderror"
                                                        placeholder="Ej: Otra bacteria" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label class="text-black"><b>Técnica Aplicada</b><span class="text-danger"></span></label>
                                                <div class="input-group input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-list"></i>
                                                        </span>
                                                    </div>
                                                    <select
                                                        wire:model.defer="Analiticas.tecnica_tercera_id"
                                                        class="form-control selectpicker form-control-solid @error('Analiticas.tecnica_tercera_id') is-invalid @enderror"
                                                        data-size="7"
                                                        data-live-search="true"
                                                        data-show-subtext="true"
                                                        required>
                                                        <option value="">Selecciona una Técnica</option>
                                                        @if(!is_null($tecnicas))
                                                        @foreach ($tecnicas as $objTecn)
                                                            <option data-subtext="" value="{{ $objTecn->id }}">{{ $objTecn->descripcion }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="text-black"><b>Resultado</b><span class="text-danger"></span></label>
                                                <div class="input-group input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-list"></i>
                                                        </span>
                                                    </div>
                                                    <select
                                                        wire:model.defer="Analiticas.resultado_tercera_id"
                                                        class="form-control selectpicker form-control-solid @error('Analiticas.resultado_tercera_id') is-invalid @enderror"
                                                        data-size="7"
                                                        data-live-search="true"
                                                        data-show-subtext="true"
                                                        required>
                                                        <option value="">Selecciona un Resultado</option>
                                                        @if(!is_null($reportes))
                                                        @foreach ($reportes as $objRep)
                                                            <option data-subtext="" value="{{ $objRep->id }}">{{ $objRep->descripcion }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="text-black"><b>Agente identificado</b></label>
                                                <div class="input-group input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-edit"></i>
                                                        </span>
                                                    </div>
                                                    <input
                                                        wire:model.defer="Analiticas.identificado_tercera"
                                                        type="text"
                                                        required
                                                        class="form-control form-control-solid @error('Analiticas.identificado_tercera') is-invalid @enderror"
                                                        placeholder="Ej: Otra bacteria" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label class="text-black"><b>Técnica Aplicada</b><span class="text-danger"></span></label>
                                                <div class="input-group input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-list"></i>
                                                        </span>
                                                    </div>
                                                    <select
                                                        wire:model.defer="Analiticas.tecnica_cuarta_id"
                                                        class="form-control selectpicker form-control-solid @error('Analiticas.tecnica_cuarta_id') is-invalid @enderror"
                                                        data-size="7"
                                                        data-live-search="true"
                                                        data-show-subtext="true"
                                                        required>
                                                        <option value="">Selecciona una Técnica</option>
                                                        @if(!is_null($tecnicas))
                                                        @foreach ($tecnicas as $objTecn)
                                                            <option data-subtext="" value="{{ $objTecn->id }}">{{ $objTecn->descripcion }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="text-black"><b>Resultado</b><span class="text-danger"></span></label>
                                                <div class="input-group input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-list"></i>
                                                        </span>
                                                    </div>
                                                    <select
                                                        wire:model.defer="Analiticas.resultado_cuarta_id"
                                                        class="form-control selectpicker form-control-solid @error('Analiticas.resultado_cuarta_id') is-invalid @enderror"
                                                        data-size="7"
                                                        data-live-search="true"
                                                        data-show-subtext="true"
                                                        required>
                                                        <option value="">Selecciona un Resultado</option>
                                                        @if(!is_null($reportes))
                                                        @foreach ($reportes as $objRep)
                                                            <option data-subtext="" value="{{ $objRep->id }}">{{ $objRep->descripcion }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="text-black"><b>Agente identificado</b></label>
                                                <div class="input-group input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-edit"></i>
                                                        </span>
                                                    </div>
                                                    <input
                                                        wire:model.defer="Analiticas.identificado_cuarta"
                                                        type="text"
                                                        required
                                                        class="form-control form-control-solid @error('Analiticas.identificado_cuarta') is-invalid @enderror"
                                                        placeholder="Ej: Otra bacteria" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label class="text-black"><b>Técnica Aplicada</b><span class="text-danger"></span></label>
                                                <div class="input-group input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-list"></i>
                                                        </span>
                                                    </div>
                                                    <select
                                                        wire:model.defer="Analiticas.tecnica_quinta_id"
                                                        class="form-control selectpicker form-control-solid @error('Analiticas.tecnica_quinta_id') is-invalid @enderror"
                                                        data-size="7"
                                                        data-live-search="true"
                                                        data-show-subtext="true"
                                                        required>
                                                        <option value="0">Selecciona una Técnica</option>
                                                        @if(!is_null($tecnicas))
                                                        @foreach ($tecnicas as $objTecn)
                                                            <option data-subtext="" value="{{ $objTecn->id }}">{{ $objTecn->descripcion }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="text-black"><b>Resultado</b><span class="text-danger"></span></label>
                                                <div class="input-group input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-list"></i>
                                                        </span>
                                                    </div>
                                                    <select
                                                        wire:model.defer="Analiticas.resultado_quinta_id"
                                                        class="form-control selectpicker form-control-solid @error('Analiticas.resultado_quinta_id') is-invalid @enderror"
                                                        data-size="7"
                                                        data-live-search="true"
                                                        data-show-subtext="true"
                                                        required>
                                                        <option value="0">Selecciona un Resultado</option>
                                                        @if(!is_null($reportes))
                                                        @foreach ($reportes as $objRep)
                                                            <option data-subtext="" value="{{ $objRep->id }}">{{ $objRep->descripcion }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="text-black"><b>Agente identificado</b></label>
                                                <div class="input-group input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-edit"></i>
                                                        </span>
                                                    </div>
                                                    <input
                                                        wire:model.defer="Analiticas.identificado_quinta"
                                                        type="text"
                                                        required
                                                        class="form-control form-control-solid @error('Analiticas.identificado_quinta') is-invalid @enderror"
                                                        placeholder="Ej: Otra bacteria" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-5">
                                                <label class="text-black"><b>Técnica Aplicada</b><span class="text-danger"></span></label>
                                                <div class="input-group input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-list"></i>
                                                        </span>
                                                    </div>
                                                    <select
                                                        wire:model.defer="Analiticas.tecnica_sexta_id"
                                                        class="form-control selectpicker form-control-solid @error('Analiticas.tecnica_sexta_id') is-invalid @enderror"
                                                        data-size="7"
                                                        data-live-search="true"
                                                        data-show-subtext="true"
                                                        required>
                                                        <option value="0">Selecciona una Técnica</option>
                                                        @if(!is_null($tecnicas))
                                                        @foreach ($tecnicas as $objTecn)
                                                            <option data-subtext="" value="{{ $objTecn->id }}">{{ $objTecn->descripcion }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="text-black"><b>Resultado</b><span class="text-danger"></span></label>
                                                <div class="input-group input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-list"></i>
                                                        </span>
                                                    </div>
                                                    <select
                                                        wire:model.defer="Analiticas.resultado_sexta_id"
                                                        class="form-control selectpicker form-control-solid @error('Analiticas.resultado_sexta_id') is-invalid @enderror"
                                                        data-size="7"
                                                        data-live-search="true"
                                                        data-show-subtext="true"
                                                        required>
                                                        <option value="0">Selecciona un Resultado</option>
                                                        @if(!is_null($reportes))
                                                        @foreach ($reportes as $objRep)
                                                            <option data-subtext="" value="{{ $objRep->id }}">{{ $objRep->descripcion }}</option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="text-black"><b>Agente identificado</b></label>
                                                <div class="input-group input-group-solid">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fas fa-edit"></i>
                                                        </span>
                                                    </div>
                                                    <input
                                                        wire:model.defer="Analiticas.identificado_sexta"
                                                        type="text"
                                                        required
                                                        class="form-control form-control-solid @error('Analiticas.identificado_sexta') is-invalid @enderror"
                                                        placeholder="Ej: Otra bacteria" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="d-none" type="submit"></button>
            </form>
            <!--end::Form-->

        </div>
        <div class="card-header" >
            <div class="card-toolbar">
                <button
                    wire:click="{{ $method }}"
                    wire:loading.class="spinner spinner-white spinner-right"
                    wire:target="{{ $method }}"
                    class="btn btn-primary font-weight-bolder mr-2">
                    <i class="fa fa-save"></i>
                    Guardar Cambios
                </button>
            </div>
        </div>
    </div>
    <!--end::Card-->

    @section('footer')
        <script src="{{ asset('assets/plugins/custom/bfi/bfi.js') }}"></script>
        <script src="{{ asset('assets') }}/js/pages/crud/forms/widgets/bootstrap-datepicker.js"></script>
        <script language="javascript">
            function veroficio(nombre){
            window.open('/storage/'+nombre);
            }
        </script>
        <script>
            function app() {
                return {
                    removeFile(functionRemove, fileId) {
                        @this.call(functionRemove);
                        bfi_clear('#'+fileId);
                    },
                }
            }

            Livewire.on('renderJs', function(){
                $('.selectpicker').selectpicker({
                    liveSearch: true,
                    showSubtext: true
                });
            });

            function ver_ocultar() {
                var x = document.getElementById("add_muestras");
                if (x.style.visibility === "visible") {
                    x.style.visibility = "hidden";
                } else {
                    x.style.visibility = "visible";
                }
            }
        </script>
    @endsection

</div>
