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
                            <a href="{{ route('analitica.index') }}" class="navi-link py-4 {{ active('user.index') }}">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i aria-hidden="true" class="ki ki-bold-close icon-lg"></i>
                                </button>
                            </a>
                            <h3 class="text-dark font-weight-bold mb-10">Información general</h3>
                            @include('component.error-list')
                            <div class="form-row">
                                <div class="form-group col-md-6">
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
                                <div class="form-group col-md-6">
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
                                            required disabled>
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
                                <div class="form-group col-md-1">
                                    <label>Id-Código<span class="text-danger">*</span></label>
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
                                            value = {{ $preanalitica->paciente->id }} />
                                    </div>
                                </div>
                                <div class="form-group col-md-1">
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
                                            value = {{ $preanalitica->paciente->sexo->nombre }}>
                                    </div>
                                </div>
                                <div class="form-group col-md-1">
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
                                            $edad = ($ahora-$tiempo)/(60*60*24*365.25);
                                            $edad = floor($edad);
                                            $anios = $edad.'_'.'años';?>
                                            value = {{ $anios }} >
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
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
                                            value = "{{ $preanalitica->probable_infeccion }}" >
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
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2">
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
                            </div>
                            <div class="form-row">
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
                                <div class="form-group col-md-2">
                                    <label>Fecha atención<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input
                                            type="date"
                                            value="{{ $preanalitica->fecha_atencion }}"
                                            class="start_date form-control form-control-solid @error('Analiticas.fecha_toma') is-invalid @enderror"
                                            placeholder="Seleccione una fecha" disabled
                                        />
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Recepción de muestra<span class="text-danger">*</span></label>
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
                                <div class="form-group col-md-2">
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
                                <div class="form-group col-md-2">
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
                                            wire:model.defer="Analiticas.tecnica_id"
                                            class="form-control selectpicker form-control-solid @error('Analiticas.tecnica_id') is-invalid @enderror"
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
                                            wire:model.defer="Analiticas.resultado_id"
                                            class="form-control selectpicker form-control-solid @error('Analiticas.resultado_id') is-invalid @enderror"
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
                            </div>
                            @if($Analiticas->crns_id==3)
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
                                    <label class="text-black"><b>Recomendación</b></label>
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
                            @endif
                            @if($Analiticas->crns_id==12)
                            <div class="form-row">
                                <div class="form-group col-md-3">
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
                                <div class="form-group col-md-3">
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
                                <div class="form-group col-md-6">
                                    <label class="text-black"><b>Recomendación</b></label>
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
                            @endif
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
                    liveSearch: true
                });
            });
        </script>
    @endsection

</div>
