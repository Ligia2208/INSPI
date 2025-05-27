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
                                            required>
                                            <option value="">Selecciona estado muestra</option>
                                            @foreach ($estados as $objEstados)
                                                <option data-subtext="" value="{{ $objEstados->id }}">
                                                    {{ $objEstados->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <label>Otras Observaciones <span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-sticky-note"></i>
                                            </span>
                                        </div>
                                        <textarea 
                                            class="form-control form-control-solid"
                                            placeholder="Ej: Detalles adicionales de la muestra"
                                            rows="3">{{$preanalitica->otras_observaciones}}</textarea>
                                    </div>
                                </div>

                            </div>



                            <hr>
                            <h3 class="text-dark font-weight-bold mb-10">Datos del Paciente</h3>
                            <div class="form-row">

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
                                            wire:model.defer="paciente.sexo_id"
                                            required disabled
                                            class="form-control form-control-solid"
                                            >
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
                                            wire:model="edad_paciente">
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


                                <div class="form-group col-md-3">
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


                            </div>


                            <hr>
                            <h3 class="text-dark font-weight-bold mb-10">Datos del procesamiento</h3>
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
                                    <label class="text-black"><b>Cod. Muestra Hospitalaria</b><span class="text-danger"></span></label>
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
                                            placeholder="Ej: 4A39982" disabled/>
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

                                <div class="form-group col-md-3">
                                    <label class="text-black"><b>CT </b><span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input
                                            wire:model.defer="Analiticastoxico.ct"
                                            type="text" required
                                            class="start_date form-control form-control-solid @error('Analiticastoxico.ct') is-invalid @enderror"
                                            placeholder="Ingrese CT"
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
                                            class="form-control form-control-solid @error('Analiticastoxico.tecnica_id') is-invalid @enderror"
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

                            <div class="form-row">

                                {{-- Select de Evento Infectológico --}}
                                <div class="form-group col-md-4 mt-3">
                                    <label class="text-black"><b>Evento Infectológico</b><span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-list"></i></span>
                                        </div>
                                        <select
                                            wire:model="res_evento_id"
                                            class="form-control selectpicker form-control-solid"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true"
                                            required>
                                            <option value="">Selecciona un Evento</option>
                                            @foreach ($resul_eventos as $evento)
                                                <option value="{{ $evento->id }}">{{ $evento->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                @if($res_evento_id == 1)
                                {{-- Select de Subvariante --}}
                                <div class="form-group col-md-4 mt-3">
                                    <label class="text-black"><b>Subvariante/Subtipo</b></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-code-branch"></i></span>
                                        </div>
                                        <select
                                            wire:model="subvariante_id"
                                            class="form-control selectpicker form-control-solid"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true">
                                            <option value="">Selecciona una Subvariante</option>
                                            @foreach ($resul_subvariantes as $subvariante)
                                                <option value="{{ $subvariante->id }}">{{ $subvariante->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                @elseif($res_evento_id == 2)
                                {{-- Select de Variante --}}
                                <div class="form-group col-md-4 mt-3">
                                    <label class="text-black"><b>Variante/Tipo</b></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-code-branch"></i></span>
                                        </div>
                                        <select
                                            wire:model="variante_id"
                                            class="form-control selectpicker form-control-solid"
                                            data-size="7"
                                            data-live-search="true"
                                            data-show-subtext="true">
                                            <option value="">Selecciona una Variante</option>
                                            @foreach ($resul_variantes as $variante)
                                                <option value="{{ $variante->id }}">{{ $variante->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif


                            </div>


                            @if($Analiticastoxico->crns_id==3)
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
                                                            wire:model.defer="Analiticastoxico.identificado"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.identificado') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.recomendacion_bacterio"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.recomendacion_bacterio') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.antibioticopsunobacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.antibioticopsunobacte_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.halopsuno_bacte"
                                                            type="number"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.halopsuno_bacte') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.escalapsunobacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.escalapsunobacte_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.antibioticopsdosbacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.antibioticopsdosbacte_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.halopsdos_bacte"
                                                            type="number"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.halopsdos_bacte') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.escalapsdosbacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.escalapsdosbacte_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.antibioticopstresbacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.antibioticopstresbacte_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.halopstres_bacte"
                                                            type="number"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.halopstres_bacte') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.escalapstresbacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.escalapstresbacte_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.antibioticopscuatrobacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.antibioticopscuatrobacte_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.halopscuatro_bacte"
                                                            type="number"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.halopscuatro_bacte') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.escalapscuatrobacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.escalapscuatrobacte_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.antibioticopscincobacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.antibioticopscincobacte_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.halopscinco_bacte"
                                                            type="number"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.halopscinco_bacte') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.escalapscincobacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.escalapscincobacte_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.antibioticopsseisbacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.antibioticopsseisbacte_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.halopsseis_bacte"
                                                            type="number"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.halopsseis_bacte') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.escalapsseisbacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.escalapsseisbacte_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.antibioticomdunobacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.antibioticomdunobacte_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.cimmduno_bacte"
                                                            type="number"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.cimmduno_bacte') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.escalamdunobacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.escalamdunobacte_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.antibioticomddosbacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.antibioticomddosbacte_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.cimmddos_bacte"
                                                            type="number"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.cimmddos_bacte') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.escalamddosbacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.escalamddosbacte_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.antibioticomdtresbacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.antibioticomdtresbacte_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.cimmdtres_bacte"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.cimmdtres_bacte') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.escalamdtresbacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.escalamdtresbacte_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.antibioticomdcuatrobacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.antibioticomdcuatrobacte_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.cimmdcuatro_bacte"
                                                            type="number"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.cimmdcuatro_bacte') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.escalamdcuatrobacte_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.escalamdcuatrobacte_id') is-invalid @enderror"
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
                            @if($Analiticastoxico->crns_id==12)
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
                                                    <label class="text-black"><b>Carga Viral</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticastoxico.carga_viral"
                                                            type="numeric"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.carga_viral') is-invalid @enderror"
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
                                                <div class="form-group col-md-8">
                                                    <label class="text-black"><b>Observación</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticastoxico.recomendacion_inmuno"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.recomendacion_inmuno') is-invalid @enderror"
                                                            placeholder="Ej: Realizar pruebas adicionales condicionadas" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($Analiticastoxico->crns_id==6)
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
                                                            wire:model.defer="Analiticastoxico.germenaislado_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.germenaislado_mico') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.directokoh_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.directokoh_mico') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.directoplaca_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.directoplaca_mico') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.tintachina_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.tintachina_mico') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.deteccionunomico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.deteccionunomico_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.interpretaunomico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.interpretaunomico_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.detecciondosmico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.detecciondosmico_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.interpretadosmico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.interpretadosmico_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.detecciontresmico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.detecciontresmico_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.interpretatresmico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.interpretatresmico_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.deteccioncuatromico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.deteccioncuatromico_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.interpretacuatromico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.interpretacuatromico_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.antibiogramamico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.antibiogramamico_id') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.fungicounomico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.fungicounoid_mico') is-invalid @enderror"
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
                                                    <label class="text-black"><b>CIM</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticastoxico.cimuno_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.cimuno_mico') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.difusionuno_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.cimuno_mico') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.escalaunomico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.escalaid_mico') is-invalid @enderror"
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
                                                    <label class="text-black"><b>Antifúngico</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticastoxico.fungicodosmico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.fungicodosmico_id') is-invalid @enderror"
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
                                                    <label class="text-black"><b>CIM</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticastoxico.cimdos_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.cimdos_mico') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.difusiondos_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.cimdos_mico') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.escaladosmico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.escaladosmico_id') is-invalid @enderror"
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
                                                    <label class="text-black"><b>Antifúngico</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticastoxico.fungicotresmico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.fungicotresmico_id') is-invalid @enderror"
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
                                                    <label class="text-black"><b>CIM</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticastoxico.cimtres_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.cimtres_mico') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.difusiontres_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.difusiontres_mico') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.escalatresmico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.escalatresmico_id') is-invalid @enderror"
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
                                                    <label class="text-black"><b>Antifúngico</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticastoxico.fungicocuatromico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.fungicocuatromico_id') is-invalid @enderror"
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
                                                    <label class="text-black"><b>CIM</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticastoxico.cimcuatro_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.cimcuatro_mico') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.difusioncuatro_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.difusioncuatro_mico') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.escalacuatromico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.escalacuatromico_id') is-invalid @enderror"
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
                                                    <label class="text-black"><b>Antifúngico</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticastoxico.fungicocincomico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.fungicocincomico_id') is-invalid @enderror"
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
                                                    <label class="text-black"><b>CIM</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticastoxico.cimcinco_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.cimcinco_mico') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.difusioncinco_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.difusioncinco_mico') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.escalacincomico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.escalacincomico_id') is-invalid @enderror"
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
                                                    <label class="text-black"><b>Antifúngico</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticastoxico.fungicoseismico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.fungicoseismico_id') is-invalid @enderror"
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
                                                    <label class="text-black"><b>CIM</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticastoxico.cimseis_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.cimseis_mico') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.difusionseis_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.difusionseis_mico') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.escalaseismico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.escalaseismico_id') is-invalid @enderror"
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
                                                    <label class="text-black"><b>Antifúngico</b><span class="text-danger"></span></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-list"></i>
                                                            </span>
                                                        </div>
                                                        <select
                                                            wire:model.defer="Analiticastoxico.fungicosietemico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.fungicosietemico_id') is-invalid @enderror"
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
                                                    <label class="text-black"><b>CIM</b></label>
                                                    <div class="input-group input-group-solid">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                        </div>
                                                        <input
                                                            wire:model.defer="Analiticastoxico.cimsiete_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.cimsiete_mico') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.difusionsiete_mico"
                                                            type="text"
                                                            required
                                                            class="form-control form-control-solid @error('Analiticastoxico.difusionsiete_mico') is-invalid @enderror"
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
                                                            wire:model.defer="Analiticastoxico.escalasietemico_id"
                                                            class="form-control selectpicker form-control-solid @error('Analiticastoxico.escalasietemico_id') is-invalid @enderror"
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

                                    <div class="form-group col-md-12">
                                        <label class="text-black"><b>Observación/Investigación:</b></label>
                                        <div class="input-group input-group-solid">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-edit"></i>
                                                </span>
                                            </div>
                                            <textarea
                                                wire:model.defer="Analiticastoxico.observacioninvestiga"
                                                id=""
                                                cols="30"
                                                rows="2"
                                                class="form-control form-control-solid @error('Analiticastoxico.observacioninvestiga') is-invalid @enderror"
                                                placeholder="Ej: Datos relevantes a reportar"
                                                >
                                            </textarea>
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

                                @if($Analiticastoxico->crns_id==9)
                                <li role="presentation" wire:ignore>
                                    <a class="btn btn-default" href="#tab-13" aria-controls="#tab-13" role="tab" data-toggle="tab">Resultados Organismo</a>
                                </li>

                                @endif

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

                                @if($Analiticastoxico->crns_id==9)
                                <div role="tabpanel" class="tab-pane" id="tab-13" wire:ignore.self>
                                    <div class="col-md-12 col-md-offset-2">

                                        <div>

                                            <div class="form-group">
                                                <label for="tipo">Seleccionar tipo:</label>
                                                <select wire:model="tipo" class="form-control">
                                                    @foreach($tipo_organismos as $tipo_organismo)
                                                    <option value="{{ $tipo_organismo->id }}">{{ $tipo_organismo->descripcion }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div>
                                                <strong>Tipo seleccionado: {{ $tipo }}</strong>
                                            </div>


                                            {{-- BACTERIAS --}}
                                            @if($tipo == 1)
                                                <div class="card mt-3 p-3 border" wire:key="tipo-1">
                                                    <h5>Bacterias</h5>

                                                    <div class="row mt-4">

                                                        <!-- <div class="form-group col-md-12">
                                                            <label for="tipo">Seleccionar tipo:</label>
                                                            <select wire:model.defer="id_tipo_organismo" class="form-control" readonly>
                                                                @foreach($tipo_organismos as $tipo_organismo)
                                                                    @if($tipo_organismo->id ==1)
                                                                    <option value="{{ $tipo_organismo->id }}" selected>{{ $tipo_organismo->descripcion }}</option>
                                                                    @else
                                                                    <option value="{{ $tipo_organismo->id }}">{{ $tipo_organismo->descripcion }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div> -->

                                                        <div class="form-group col-md-6">
                                                            <label>Identificación</label>
                                                            <input type="text" wire:model.defer="OrganismoTmp.identificacion" class="form-control form-control-solid @error('OrganismoTmp.identificacion') is-invalid @enderror" placeholder="Campo ingresado en función de los hallazgos">
                                                            @error('OrganismoTmp.identificacion')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label>Técnica de construcción de librerías</label>
                                                            <select wire:model.defer="OrganismoTmp.tecnica_libreria" class="form-control   @error('OrganismoTmp.tecnica_libreria') is-invalid @enderror">
                                                                <option value="AMPICONES">AMPICONES</option>
                                                                <option value="METAGENOMICA">METAGENÓMICA</option>
                                                            </select>
                                                            @error('OrganismoTmp.tecnica_libreria')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-4 mt-2">
                                                            <label>Q30 ≥ 80%</label>
                                                            <select wire:model.defer="OrganismoTmp.q30_estado" class="form-control   @error('OrganismoTmp.q30_estado') is-invalid @enderror">
                                                                <option value="CUMPLE">CUMPLE</option>
                                                                <option value="NO CUMPLE">NO CUMPLE</option>
                                                            </select>
                                                            @error('OrganismoTmp.q30_estado')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-4 mt-2">
                                                            <label>Secuencia con Ns ≤50%</label>
                                                            <select wire:model.defer="OrganismoTmp.secuencia_ns" class="form-control   @error('OrganismoTmp.secuencia_ns') is-invalid @enderror">
                                                                <option value="CUMPLE">CUMPLE</option>
                                                                <option value="NO CUMPLE">NO CUMPLE</option>
                                                            </select>
                                                            @error('OrganismoTmp.secuencia_ns')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-4 mt-2">
                                                            <label>Fecha de entrega de informe de resultados</label>
                                                            <input type="date" wire:model.defer="OrganismoTmp.fecha_entrega" class="form-control  form-control-solid @error('OrganismoTmp.fecha_entrega') is-invalid @enderror">
                                                            @error('OrganismoTmp.fecha_entrega')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12 mt-2">
                                                            <label>Otros</label>
                                                            <input type="text" wire:model.defer="OrganismoTmp.otros" class="form-control form-control-solid @error('OrganismoTmp.otros') is-invalid @enderror" placeholder="Ej. Serotipo si aplica">
                                                            @error('OrganismoTmp.otros')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12 mt-2">
                                                            <label>Información</label>
                                                            <textarea wire:model.defer="OrganismoTmp.informacion" class="form-control form-control-solid @error('OrganismoTmp.informacion') is-invalid @enderror" placeholder="Información adicional emitida en el informe técnico"></textarea>
                                                            @error('OrganismoTmp.informacion')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                    </div>
                                                    
                                                </div>
                                            @endif

                                            {{-- MICOBACTERIAS --}}
                                            @if($tipo == 5)
                                                <div class="card mt-3 p-3 border">
                                                    <h5>Micobacterias</h5>
                                                    <div class="row">

                                                        <div class="form-group col-md-6">
                                                            <label>Tipo de micobacteria</label>
                                                            <select class="form-control   @error('OrganismoTmp.tipo_micobacteria') is-invalid @enderror" wire:model.defer="OrganismoTmp.tipo_micobacteria">
                                                                <option value="Tuberculosa">Tuberculosa</option>
                                                                <option value="No tuberculosa">No tuberculosa</option>
                                                            </select>
                                                            @error('OrganismoTmp.tipo_micobacteria')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                 

                                                        <div class="form-group col-md-6">
                                                            <label>Clado</label>
                                                            <input type="text" class="form-control form-control-solid @error('OrganismoTmp.clado') is-invalid @enderror" wire:model.defer="OrganismoTmp.clado" placeholder="Ej. M. tuberculosis complex, M. avium complex, etc.">
                                                            @error('OrganismoTmp.clado')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-6 mt-2">
                                                            <label>Linaje y sublinaje</label>
                                                            <input type="text" class="form-control form-control-solid @error('OrganismoTmp.linaje_sublinaje') is-invalid @enderror" wire:model.defer="OrganismoTmp.linaje_sublinaje" placeholder="Ej. L4.3.4, L5.1, etc.">
                                                            @error('OrganismoTmp.linaje_sublinaje')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-6 mt-2">
                                                            <label>Técnica de construcción de librerías</label>
                                                            <select class="form-control   @error('OrganismoTmp.tecnica_libreria') is-invalid @enderror" wire:model.defer="OrganismoTmp.tecnica_libreria">
                                                                <option value="AMPICONES">AMPICONES</option>
                                                                <option value="AMPICONES">METAGENÓMICA</option>
                                                            </select>
                                                            @error('OrganismoTmp.tecnica_libreria')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-4 mt-2">
                                                            <label>Q30 ≥ 80%</label>
                                                            <select class="form-control   @error('OrganismoTmp.q30_estado') is-invalid @enderror" wire:model.defer="OrganismoTmp.q30_estado">
                                                                <option>CUMPLE</option>
                                                                <option>NO CUMPLE</option>
                                                            </select>
                                                            @error('OrganismoTmp.q30_estado')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-4 mt-2">
                                                            <label>Secuencia con Ns ≤50%</label>
                                                            <select class="form-control   @error('OrganismoTmp.secuencia_ns') is-invalid @enderror" wire:model.defer="OrganismoTmp.secuencia_ns">
                                                                <option>CUMPLE</option>
                                                                <option>NO CUMPLE</option>
                                                            </select>
                                                            @error('OrganismoTmp.secuencia_ns')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-4 mt-2">
                                                            <label>Fecha de entrega de informe de resultados</label>
                                                            <input type="date" class="form-control form-control-solid @error('OrganismoTmp.fecha_entrega') is-invalid @enderror" wire:model.defer="OrganismoTmp.fecha_entrega">
                                                            @error('OrganismoTmp.fecha_entrega')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12 mt-2">
                                                            <label>Otros</label>
                                                            <input type="text" wire:model.defer="OrganismoTmp.otros" class="form-control form-control-solid @error('OrganismoTmp.otros') is-invalid @enderror" placeholder="Ej. Serotipo si aplica">
                                                            @error('OrganismoTmp.otros')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>  
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12 mt-2">
                                                            <label>Información</label>
                                                            <textarea class="form-control form-control-solid @error('OrganismoTmp.informacion') is-invalid @enderror" wire:model.defer="OrganismoTmp.informacion" placeholder="Información adicional emitida en el informe técnico"></textarea>
                                                            @error('OrganismoTmp.informacion')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                    </div>

                                                </div>
                                            @endif

                                            {{-- HONGOS --}}
                                            @if($tipo == 4)
                                                <div class="card mt-3 p-3 border">
                                                    <h5>Hongos</h5>
                                                    <div class="row">

                                                        <div class="form-group col-md-6">
                                                            <label>Identificación</label>
                                                            <input type="text" wire:model.defer="OrganismoTmp.identificacion" class="form-control form-control-solid @error('OrganismoTmp.identificacion') is-invalid @enderror" placeholder="Campo ingresado en función de los hallazgos">
                                                            @error('OrganismoTmp.identificacion')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label>Clado</label>
                                                            <input type="text" class="form-control form-control-solid @error('OrganismoTmp.clado') is-invalid @enderror" wire:model.defer="OrganismoTmp.clado" placeholder="Ej. M. tuberculosis complex, M. avium complex, etc.">
                                                            @error('OrganismoTmp.clado')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-6 mt-2">
                                                            <label>Linaje y sublinaje</label>
                                                            <input type="text" class="form-control form-control-solid @error('OrganismoTmp.linaje_sublinaje') is-invalid @enderror" wire:model.defer="OrganismoTmp.linaje_sublinaje" placeholder="Ej. L4.3.4, L5.1, etc.">
                                                            @error('OrganismoTmp.linaje_sublinaje')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-6 mt-2">
                                                            <label>Técnica de construcción de librerías</label>
                                                            <select class="form-control   @error('OrganismoTmp.tecnica_libreria') is-invalid @enderror" wire:model.defer="OrganismoTmp.tecnica_libreria">
                                                                <option value="AMPICONES">AMPICONES</option>
                                                                <option value="AMPICONES">METAGENÓMICA</option>
                                                            </select>
                                                            @error('OrganismoTmp.tecnica_libreria')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-4 mt-2">
                                                            <label>Q30 ≥ 80%</label>
                                                            <select class="form-control   @error('OrganismoTmp.q30_estado') is-invalid @enderror" wire:model.defer="OrganismoTmp.q30_estado">
                                                                <option>CUMPLE</option>
                                                                <option>NO CUMPLE</option>
                                                            </select>
                                                            @error('OrganismoTmp.q30_estado')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-4 mt-2">
                                                            <label>Secuencia con Ns ≤50%</label>
                                                            <select class="form-control   @error('OrganismoTmp.secuencia_ns') is-invalid @enderror" wire:model.defer="OrganismoTmp.secuencia_ns">
                                                                <option>CUMPLE</option>
                                                                <option>NO CUMPLE</option>
                                                            </select>
                                                            @error('OrganismoTmp.secuencia_ns')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-4 mt-2">
                                                            <label>Fecha de entrega de informe de resultados</label>
                                                            <input type="date" class="form-control form-control-solid @error('OrganismoTmp.fecha_entrega') is-invalid @enderror" wire:model.defer="OrganismoTmp.fecha_entrega">
                                                            @error('OrganismoTmp.fecha_entrega')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12 mt-2">
                                                            <label>Otros</label>
                                                            <input type="text" wire:model.defer="OrganismoTmp.otros" class="form-control form-control-solid @error('OrganismoTmp.otros') is-invalid @enderror" placeholder="Ej. Serotipo si aplica">
                                                            @error('OrganismoTmp.otros')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>  
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12 mt-2">
                                                            <label>Información</label>
                                                            <textarea class="form-control form-control-solid @error('OrganismoTmp.informacion') is-invalid @enderror" wire:model.defer="OrganismoTmp.informacion" placeholder="Información adicional emitida en el informe técnico"></textarea>
                                                            @error('OrganismoTmp.informacion')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                    </div>

                                                </div>
                                            @endif


                                            {{-- PARASITOS --}}
                                            @if($tipo == 3)
                                                <div class="card mt-3 p-3 border">
                                                    <h5>Parásitos</h5>
                                                    <div class="row">

                                                        <div class="form-group col-md-6">
                                                            <label>Identificación</label>
                                                            <input type="text" wire:model.defer="OrganismoTmp.identificacion" class="form-control form-control-solid @error('OrganismoTmp.identificacion') is-invalid @enderror" placeholder="Campo ingresado en función de los hallazgos">
                                                            @error('OrganismoTmp.identificacion')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-6 mt-2">
                                                            <label>Técnica de construcción de librerías</label>
                                                            <select class="form-control   @error('OrganismoTmp.tecnica_libreria') is-invalid @enderror" wire:model.defer="OrganismoTmp.tecnica_libreria">
                                                                <option value="AMPICONES">AMPICONES</option>
                                                                <option value="AMPICONES">METAGENÓMICA</option>
                                                            </select>
                                                            @error('OrganismoTmp.tecnica_libreria')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-4 mt-2">
                                                            <label>Q30 ≥ 80%</label>
                                                            <select class="form-control   @error('OrganismoTmp.q30_estado') is-invalid @enderror" wire:model.defer="OrganismoTmp.q30_estado">
                                                                <option>CUMPLE</option>
                                                                <option>NO CUMPLE</option>
                                                            </select>
                                                            @error('OrganismoTmp.q30_estado')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-4 mt-2">
                                                            <label>Secuencia con Ns ≤50%</label>
                                                            <select class="form-control   @error('OrganismoTmp.secuencia_ns') is-invalid @enderror" wire:model.defer="OrganismoTmp.secuencia_ns">
                                                                <option>CUMPLE</option>
                                                                <option>NO CUMPLE</option>
                                                            </select>
                                                            @error('OrganismoTmp.secuencia_ns')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-4 mt-2">
                                                            <label>Fecha de entrega de informe de resultados</label>
                                                            <input type="date" class="form-control form-control-solid @error('OrganismoTmp.fecha_entrega') is-invalid @enderror" wire:model.defer="OrganismoTmp.fecha_entrega">
                                                            @error('OrganismoTmp.fecha_entrega')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12 mt-2">
                                                            <label>Otros</label>
                                                            <input type="text" wire:model.defer="OrganismoTmp.otros" class="form-control form-control-solid @error('OrganismoTmp.otros') is-invalid @enderror" placeholder="Ej. Serotipo si aplica">
                                                            @error('OrganismoTmp.otros')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>  
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12 mt-2">
                                                            <label>Información</label>
                                                            <textarea class="form-control form-control-solid @error('OrganismoTmp.informacion') is-invalid @enderror" wire:model.defer="OrganismoTmp.informacion" placeholder="Información adicional emitida en el informe técnico"></textarea>
                                                            @error('OrganismoTmp.informacion')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                    </div>

                                                </div>
                                            @endif


                                            {{-- INSECTOS --}}
                                            @if($tipo == 6)
                                                <div class="card mt-3 p-3 border">
                                                    <h5>Insectos</h5>
                                                    <div class="row">

                                                        <div class="form-group col-md-6">
                                                            <label>Identificación</label>
                                                            <input type="text" wire:model.defer="OrganismoTmp.identificacion" class="form-control form-control-solid @error('OrganismoTmp.identificacion') is-invalid @enderror" placeholder="Campo ingresado en función de los hallazgos">
                                                            @error('OrganismoTmp.identificacion')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-6 mt-2">
                                                            <label>Técnica de construcción de librerías</label>
                                                            <select class="form-control   @error('OrganismoTmp.tecnica_libreria') is-invalid @enderror" wire:model.defer="OrganismoTmp.tecnica_libreria">
                                                                <option value="AMPICONES">AMPICONES</option>
                                                                <option value="AMPICONES">METAGENÓMICA</option>
                                                            </select>
                                                            @error('OrganismoTmp.tecnica_libreria')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-4 mt-2">
                                                            <label>Q30 ≥ 80%</label>
                                                            <select class="form-control   @error('OrganismoTmp.q30_estado') is-invalid @enderror" wire:model.defer="OrganismoTmp.q30_estado">
                                                                <option>CUMPLE</option>
                                                                <option>NO CUMPLE</option>
                                                            </select>
                                                            @error('OrganismoTmp.q30_estado')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-4 mt-2">
                                                            <label>Secuencia con Ns ≤50%</label>
                                                            <select class="form-control   @error('OrganismoTmp.secuencia_ns') is-invalid @enderror" wire:model.defer="OrganismoTmp.secuencia_ns">
                                                                <option>CUMPLE</option>
                                                                <option>NO CUMPLE</option>
                                                            </select>
                                                            @error('OrganismoTmp.secuencia_ns')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-4 mt-2">
                                                            <label>Fecha de entrega de informe de resultados</label>
                                                            <input type="date" class="form-control form-control-solid @error('OrganismoTmp.fecha_entrega') is-invalid @enderror" wire:model.defer="OrganismoTmp.fecha_entrega">
                                                            @error('OrganismoTmp.fecha_entrega')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12 mt-2">
                                                            <label>Otros</label>
                                                            <input type="text" wire:model.defer="OrganismoTmp.otros" class="form-control form-control-solid @error('OrganismoTmp.otros') is-invalid @enderror" placeholder="Ej. Serotipo si aplica">
                                                            @error('OrganismoTmp.otros')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>  
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12 mt-2">
                                                            <label>Información</label>
                                                            <textarea class="form-control form-control-solid @error('OrganismoTmp.informacion') is-invalid @enderror" wire:model.defer="OrganismoTmp.informacion" placeholder="Información adicional emitida en el informe técnico"></textarea>
                                                            @error('OrganismoTmp.informacion')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                    </div>

                                                </div>
                                            @endif


                                            {{-- OTROS --}}
                                            @if($tipo == 7)
                                                <div class="card mt-3 p-3 border">
                                                    <h5>Otros</h5>
                                                    <div class="row">

                                                        <div class="form-group col-md-6">
                                                            <label>Identificación</label>
                                                            <input type="text" wire:model.defer="OrganismoTmp.identificacion" class="form-control form-control-solid @error('OrganismoTmp.identificacion') is-invalid @enderror" placeholder="Campo ingresado en función de los hallazgos">
                                                            @error('OrganismoTmp.identificacion')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-6 mt-2">
                                                            <label>Número de Secuenciación</label>
                                                            <input type="text" wire:model.defer="OrganismoTmp.n_secuenciacion" class="form-control form-control-solid @error('OrganismoTmp.n_secuenciacion') is-invalid @enderror" placeholder="Ej. N° de secuenciación a la cual ingresa">
                                                            @error('OrganismoTmp.n_secuenciacion')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>  
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-3 mt-2">
                                                            <label>Técnica de construcción de librerías</label>
                                                            <select class="form-control   @error('OrganismoTmp.tecnica_libreria') is-invalid @enderror" wire:model.defer="OrganismoTmp.tecnica_libreria">
                                                                <option value="AMPICONES">AMPICONES</option>
                                                                <option value="AMPICONES">METAGENÓMICA</option>
                                                            </select>
                                                            @error('OrganismoTmp.tecnica_libreria')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-3 mt-2">
                                                            <label>Q30 ≥ 80%</label>
                                                            <select class="form-control   @error('OrganismoTmp.q30_estado') is-invalid @enderror" wire:model.defer="OrganismoTmp.q30_estado">
                                                                <option>CUMPLE</option>
                                                                <option>NO CUMPLE</option>
                                                            </select>
                                                            @error('OrganismoTmp.q30_estado')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-3 mt-2">
                                                            <label>Secuencia con Ns ≤50%</label>
                                                            <select class="form-control   @error('OrganismoTmp.secuencia_ns') is-invalid @enderror" wire:model.defer="OrganismoTmp.secuencia_ns">
                                                                <option>CUMPLE</option>
                                                                <option>NO CUMPLE</option>
                                                            </select>
                                                            @error('OrganismoTmp.secuencia_ns')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-3 mt-2">
                                                            <label>Fecha de entrega de informe de resultados</label>
                                                            <input type="date" class="form-control form-control-solid @error('OrganismoTmp.fecha_entrega') is-invalid @enderror" wire:model.defer="OrganismoTmp.fecha_entrega">
                                                            @error('OrganismoTmp.fecha_entrega')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12 mt-2">
                                                            <label>Información</label>
                                                            <textarea class="form-control form-control-solid @error('OrganismoTmp.informacion') is-invalid @enderror" wire:model.defer="OrganismoTmp.informacion" placeholder="Información adicional emitida en el informe técnico"></textarea>
                                                            @error('OrganismoTmp.informacion')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12 mt-2">
                                                            <label>Identificación</label>
                                                            <input type="text" wire:model.defer="OrganismoTmp.identificacion" class="form-control form-control-solid @error('OrganismoTmp.identificacion') is-invalid @enderror" placeholder="Ej. Patógeno identificado">
                                                            @error('OrganismoTmp.identificacion')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>  
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12 mt-2">
                                                            <label>Nota</label>
                                                            <input type="text" wire:model.defer="OrganismoTmp.nota" class="form-control form-control-solid @error('OrganismoTmp.nota') is-invalid @enderror" placeholder="Ej. Diagnóstico de la muestra">
                                                            @error('OrganismoTmp.nota')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>  
                                                            @enderror
                                                        </div>

                                                    </div>

                                                </div>
                                            @endif

                                            {{-- VIRUS --}}
                                            @if($tipo == 2)
                                                <div class="card mt-3 p-3 border">
                                                    <h5>Virus</h5>
                                                    <div class="row">

                                                        <div class="form-group col-md-6">
                                                            <label>Identificación</label>
                                                            <input type="text" wire:model.defer="OrganismoTmp.identificacion" class="form-control form-control-solid @error('OrganismoTmp.identificacion') is-invalid @enderror" placeholder="Campo ingresado en función de los hallazgos">
                                                            @error('OrganismoTmp.identificacion')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-6 mt-2">
                                                            <label>Número de Secuenciación</label>
                                                            <input type="text" wire:model.defer="OrganismoTmp.n_secuenciacion" class="form-control form-control-solid @error('OrganismoTmp.n_secuenciacion') is-invalid @enderror" placeholder="Ej. N° de secuenciación a la cual ingresa">
                                                            @error('OrganismoTmp.n_secuenciacion')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>  
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-3 mt-2">
                                                            <label>Técnica de construcción de librerías</label>
                                                            <select class="form-control   @error('OrganismoTmp.tecnica_libreria') is-invalid @enderror" wire:model.defer="OrganismoTmp.tecnica_libreria">
                                                                <option value="AMPICONES">AMPICONES</option>
                                                                <option value="AMPICONES">METAGENÓMICA</option>
                                                            </select>
                                                            @error('OrganismoTmp.tecnica_libreria')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-3 mt-2">
                                                            <label>Q30 ≥ 80%</label>
                                                            <select class="form-control   @error('OrganismoTmp.q30_estado') is-invalid @enderror" wire:model.defer="OrganismoTmp.q30_estado">
                                                                <option>CUMPLE</option>
                                                                <option>NO CUMPLE</option>
                                                            </select>
                                                            @error('OrganismoTmp.q30_estado')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-3 mt-2">
                                                            <label>Secuencia con Ns ≤50%</label>
                                                            <select class="form-control   @error('OrganismoTmp.secuencia_ns') is-invalid @enderror" wire:model.defer="OrganismoTmp.secuencia_ns">
                                                                <option>CUMPLE</option>
                                                                <option>NO CUMPLE</option>
                                                            </select>
                                                            @error('OrganismoTmp.secuencia_ns')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-3 mt-2">
                                                            <label>Fecha de entrega de informe de resultados</label>
                                                            <input type="date" class="form-control form-control-solid @error('OrganismoTmp.fecha_entrega') is-invalid @enderror" wire:model.defer="OrganismoTmp.fecha_entrega">
                                                            @error('OrganismoTmp.fecha_entrega')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12 mt-2">
                                                            <label>Información</label>
                                                            <textarea class="form-control form-control-solid @error('OrganismoTmp.informacion') is-invalid @enderror" wire:model.defer="OrganismoTmp.informacion" placeholder="Información adicional emitida en el informe técnico"></textarea>
                                                            @error('OrganismoTmp.informacion')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="form-group col-md-12 mt-2">
                                                            <label>Identificación</label>
                                                            <input type="text" wire:model.defer="OrganismoTmp.identificacion" class="form-control form-control-solid @error('OrganismoTmp.identificacion') is-invalid @enderror" placeholder="Ej. Patógeno identificado">
                                                            @error('OrganismoTmp.identificacion')
                                                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>  
                                                            @enderror
                                                        </div>

                                                    </div>

                                                </div>
                                            @endif

                                        </div>

                                    </div>
                                </div>



                                @endif


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

            
            document.addEventListener('livewire:load', () => {
                // Inicializar una vez
                initSelects();

                Livewire.hook('message.processed', (message, component) => {
                    // Se ejecuta después de CUALQUIER actualización
                    initSelects();
                });
            });

            function initSelects() {
                //console.log("Reinicializando selectpicker y selectpicker");
                $('.selectpicker').selectpicker({
                    liveSearch: true,
                    showSubtext: true
                });
            }

            
            Livewire.on('renderJs', function(){

                //console.log("renderJs recibido");

                $('.selectpicker').selectpicker({
                    liveSearch: true,
                    showSubtext: true
                });

                $('#selecttecnica').selectpicker({
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
