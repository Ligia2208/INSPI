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
                            <a href="{{ route('analiticatoxico.index') }}" class="navi-link py-4 {{ active('user.index') }}">

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
                                                value = "{{ $Analiticastoxico->preanalitica->instituciones->descripcion }}" />
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
                                                value = "{{ $Analiticastoxico->preanalitica->instituciones->clasificacion->descripcion }} - {{ $Analiticastoxico->preanalitica->instituciones->tipologia->descripcion }} - {{ $Analiticastoxico->preanalitica->instituciones->nivel->descripcion }} ( {{ $Analiticastoxico->preanalitica->instituciones->provincia->descripcion }}-{{ $Analiticastoxico->preanalitica->instituciones->canton->descripcion }})" />
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
                                            class="start_date form-control form-control-solid @error('Analiticastoxico.fecha_recepcion') is-invalid @enderror"
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
                                            wire:model.defer="Analiticastoxico.sedes_id"
                                            wire:model="selectedSede"
                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.sedes_id') is-invalid @enderror"
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
                                            wire:model.defer="Analiticastoxico.crns_id"
                                            wire:model.live="selectedCrn"
                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.crns_id') is-invalid @enderror"
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
                                    <label>Código: <span class="text-danger">{{ $Analiticastoxico->codigo_calidad }}</span></label>
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
                                            wire:model.defer="Analiticastoxico.evento_id"
                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.evento_id') is-invalid @enderror"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required
                                            @if($Analiticastoxico->codigo_externo != '' && $Analiticastoxico->adicional == 2)
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
                                            wire:model.defer="Analiticastoxico.clase_id"
                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.clase_id') is-invalid @enderror"
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
                                            wire:model.defer="Analiticastoxico.muestra_id"
                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.evento_id') is-invalid @enderror"
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
                                            wire:model.defer="Analiticastoxico.estado_muestra_id"
                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.estado_muestra_id') is-invalid @enderror"
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
                                            class="start_date form-control form-control-solid @error('Analiticastoxico.fecha_atencion') is-invalid @enderror"
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
                                <div class="form-group col-md-4">
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
                                <div class="form-group col-md-2">
                                    <label>Año - Período<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Analiticastoxico.anio_registro"
                                            type="text"
                                            required disabled
                                            class="form-control form-control-solid @error('Analiticastoxico.anio_registro') is-invalid @enderror"
                                            placeholder="Ej: 4A39982" />
                                    </div>
                                    @error('Analiticastoxico.anio_registro')
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
                                            value={{ str_pad($Analiticastoxico->codigo_muestra, 6, "0", STR_PAD_LEFT) }}
                                            class="form-control form-control-solid @error('Analiticastoxico.codigo_muestra') is-invalid @enderror"
                                            placeholder="Ej: 4A39982" />
                                    </div>
                                    @error('Analiticastoxico.codigo_muestra')
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
                                            value={{ str_pad($Analiticastoxico->codigo_secuencial, 2, "0", STR_PAD_LEFT) }}
                                            class="form-control form-control-solid @error('Analiticastoxico.codigo_secuencial') is-invalid @enderror"
                                            placeholder="Ej: 4A39982" />
                                    </div>
                                    @error('Analiticastoxico.codigo_secuencial')
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
                                            wire:model.defer="Analiticastoxico.fecha_toma"
                                            type="date"
                                            class="start_date form-control form-control-solid @error('Analiticastoxico.fecha_toma') is-invalid @enderror"
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
                                            wire:model.defer="Analiticastoxico.hora_toma"
                                            type="time"
                                            class="start_date form-control form-control-solid @error('Analiticastoxico.hora_toma') is-invalid @enderror"
                                            placeholder="Seleccione una fecha" disabled
                                        />
                                    </div>
                                </div>
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
                                            class="start_date form-control form-control-solid @error('Analiticastoxico.fecha_atencion') is-invalid @enderror"
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
                                            wire:model.defer="Analiticastoxico.codigo_externo"
                                            type="text"
                                            required
                                            class="form-control form-control-solid @error('Analiticastoxico.codigo_externo') is-invalid @enderror"
                                            placeholder="Ej: 4A39982" />
                                    </div>
                                    @error('Analiticastoxico.codigo_externo')
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
                                            wire:model.defer="Analiticastoxico.fecha_llegada_lab"
                                            type="date" required
                                            class="start_date form-control form-control-solid @error('Analiticastoxico.fecha_llegada_lab') is-invalid @enderror"
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
                                            wire:model.defer="Analiticastoxico.fecha_procesamiento"
                                            type="date" required
                                            class="start_date form-control form-control-solid @error('Analiticastoxico.fecha_procesamiento') is-invalid @enderror"
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
                                            wire:model.defer="Analiticastoxico.tecnica_id"
                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.tecnica_id') is-invalid @enderror"
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
                                    <label class="text-black"><b>Resultado</b><span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select
                                            wire:model.defer="Analiticastoxico.resultado_id"
                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.resultado_id') is-invalid @enderror"
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
                                    @error('Analiticastoxico.resultado_id') <div><span class="text-danger">{{ $message }}</span></div> @enderror
                                </div>
                            </div>
                            @if($Analiticastoxico->crns_id==7 && ($Analiticastoxico->evento_id==99 || $Analiticastoxico->evento_id==100))
                                <ul class="nav nav-tabs nav-justified" role="tablist">
                                    <li role="presentation" class="active" wire:ignore>
                                        <a class="btn btn-default" href="#tab-1" aria-controls="#tab-1" role="tab" data-toggle="tab">Resultado Cuantitativo</a>
                                    </li>
                                </ul>
                                @include('component.error-list')
                                <div class="tab-content mt-5">
                                    <div role="tabpanel" class="tab-pane active" id="tab-1" wire:ignore.self>
                                        <div class="col-md-12 col-md-offset-2">
                                            <div class="form-row">
                                                <div class="form-group col-md-2">
                                                    <label class="text-black"><b>Nivel Alcoholemia</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticastoxico.nivel_alcohol"
                                                            type="numeric"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.nivel_alcohol') is-invalid @enderror"
                                                            placeholder="Ej: 1287" />
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label class="text-black"><b>Unidades</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticastoxico.unidades_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.unidades_id') is-invalid @enderror"
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
                                            </div>
                                        </div>
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
                                                        wire:model.defer="Analiticastoxico.descripcion"
                                                        id=""
                                                        cols="30"
                                                        rows="3"
                                                        class="form-control form-control-solid @error('Analiticastoxico.descripcion') is-invalid @enderror"
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
                                                        @if ($AnaliticaTmp || $Analiticastoxico->archivo)
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
                                                        wire:model.defer="Analiticastoxico.tecnica_segunda_id"
                                                        class="form-control selectpicker form-control-solid @error('Analiticastoxico.tecnica_segunda_id') is-invalid @enderror"
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
                                                        wire:model.defer="Analiticastoxico.resultado_segunda_id"
                                                        class="form-control selectpicker form-control-solid @error('Analiticastoxico.resultado_segunda_id') is-invalid @enderror"
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
                                                        wire:model.defer="Analiticastoxico.identificado_segunda"
                                                        type="text"
                                                        required
                                                        class="form-control form-control-solid @error('Analiticastoxico.identificado_segunda') is-invalid @enderror"
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
                                                        wire:model.defer="Analiticastoxico.tecnica_tercera_id"
                                                        class="form-control selectpicker form-control-solid @error('Analiticastoxico.tecnica_tercera_id') is-invalid @enderror"
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
                                                        wire:model.defer="Analiticastoxico.resultado_tercera_id"
                                                        class="form-control selectpicker form-control-solid @error('Analiticastoxico.resultado_tercera_id') is-invalid @enderror"
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
                                                        wire:model.defer="Analiticastoxico.identificado_tercera"
                                                        type="text"
                                                        required
                                                        class="form-control form-control-solid @error('Analiticastoxico.identificado_tercera') is-invalid @enderror"
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
                                                        wire:model.defer="Analiticastoxico.tecnica_cuarta_id"
                                                        class="form-control selectpicker form-control-solid @error('Analiticastoxico.tecnica_cuarta_id') is-invalid @enderror"
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
                                                        wire:model.defer="Analiticastoxico.resultado_cuarta_id"
                                                        class="form-control selectpicker form-control-solid @error('Analiticastoxico.resultado_cuarta_id') is-invalid @enderror"
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
                                                        wire:model.defer="Analiticastoxico.identificado_cuarta"
                                                        type="text"
                                                        required
                                                        class="form-control form-control-solid @error('Analiticastoxico.identificado_cuarta') is-invalid @enderror"
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
