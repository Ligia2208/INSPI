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
                                <a href="{{ route('postanalitica.index') }}" class="navi-link py-4 {{ active('user.index') }}">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i aria-hidden="true" class="ki ki-bold-close icon-lg"></i>
                                </button>
                            </a>
                            <h3 class="text-dark font-weight-bold mb-10">Información general</h3>
                            @include('component.error-list')

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
                                                value = "{{ $data->instituciones->descripcion }}" />
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
                                                value = "{{ $data->instituciones->clasificacion->descripcion }} - {{ $data->instituciones->tipologia->descripcion }} - {{ $data->instituciones->nivel->descripcion }} ( {{ $data->instituciones->provincia->descripcion }}-{{ $data->instituciones->canton->descripcion }})" />
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
                                            value="{{ $data->fecha_recepcion }}"
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
                                            value = {{ $data->paciente->identidad }} />
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
                                            value = "{{ $data->paciente->apellidos }} {{ $data->paciente->nombres }}">
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
                                            value = {{ $data->paciente->sexo->descripcion }}>
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
                                            value="{{ $data->paciente->fechanacimiento }}"
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
                                            $tiempo = strtotime($data->paciente->fechanacimiento);
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
                                            @if($data->embarazo=='N')
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
                                            @if($data->gestacion>0)
                                            value = {{ $data->gestacion }}
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
                                            value = "{{ $data->probable_infeccion }}" >
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
                                            value={{ $data->fecha_sintomas }} disabled
                                        />
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
                                            value = "{{ $data->quien_notifica }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <br>
                            </div>
                            <div class="table-responsive">
                                <table id="data"
                                    class="table table-head-custom table-head-bg table-borderless table-vertical-center">
                                    <thead>
                                        <tr class="text-uppercase">
                                            <label class="text-black"><b>Muestras Recibidas</b><span class="text-danger"></span></label>
                                        </tr>
                                    </thead>
                                    <thead>
                                        <tr class="text-uppercase">
                                            <th>Código Muestra</th>
                                            <th>Clase Muestra</th>
                                            <th>Tipo Muestra</th>
                                            <th>Fecha Toma</th>
                                            <th>Técnico Procesa</th>
                                            <th>Fecha Procesamiento</th>
                                            <th>Técnica</th>
                                            <th>Resultado</th>
                                            <th>Observación Técnico</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($detalles as $objAnalitica )
                                        <tr>
                                        <td>
                                            <span
                                                class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->codigo_calidad }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->clase->descripcion }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->muestra->descripcion }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->fecha_toma }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->usuarior->name }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->fecha_procesamiento }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->tecnica->descripcion }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->resultado->descripcion }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->descripcion }}</span>
                                        </td>
                                        </tr>
                                        @if($objAnalitica->crns_id==12)
                                            @if($objAnalitica->carga_viral>0)
                                            <tr>
                                                <th colspan="9">
                                                    Valores registrados durante el análisis técnico.
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="5">
                                                    <span
                                                    class="text-dark-50 font-weight-bolder d-block font-size-lg">Carga viral: {{ $objAnalitica->carga_viral }} {{ $objAnalitica->unidades->descripcion }}</span>
                                                </th>
                                                <th colspan="4">
                                                    <span
                                                    class="text-dark-50 font-weight-bolder d-block font-size-lg">Observaciones: {{ $objAnalitica->recomendacion_inmuno }}</span>
                                                </th>
                                            </tr>
                                            @endif
                                        @endif
                                        @if($objAnalitica->crns_id==3)
                                            @if($objAnalitica->identificado!='')
                                            <tr>
                                                <th colspan="9">
                                                    Valores registrados durante el análisis técnico.
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="5">
                                                    <span
                                                    class="text-dark-50 font-weight-bolder d-block font-size-lg">Agente identificado: {{ $objAnalitica->identificado }}</span>
                                                </th>
                                                <th colspan="4">
                                                    <span
                                                    class="text-dark-50 font-weight-bolder d-block font-size-lg">Observaciones: {{ $objAnalitica->recomendacion_bacterio }}</span>
                                                </th>
                                            </tr>
                                            @endif
                                            @if($objAnalitica->antibioticopsunobacte_id>0)
                                                <tr>
                                                    <th colspan="9">
                                                        <span
                                                    class="text-dark-50 font-weight-bolder d-block font-size-lg">Pruebas de Susceptibilidad - Método de difusión: Kirby Bauer</span>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->antibioticopsunobacte->descripcion }}</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->halopsuno_bacte }} mm.</span>
                                                    </th>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">@if($objAnalitica->escalapsunobacte_id==1) Sensible @else @if($objAnalitica->escalapsunobacte_id==2) Intermedio @else @if($objAnalitica->escalapsunobacte_id==3) Resistente @else Sensibilidad disminuida a penicilina  @endif @endif @endif</span>
                                                    </th>
                                                </tr>
                                            @endif
                                            @if($objAnalitica->antibioticopsdosbacte_id>0)
                                                <tr>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->antibioticopsdosbacte->descripcion }}</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->halopsdos_bacte }} mm.</span>
                                                    </th>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">@if($objAnalitica->escalapsdosbacte_id==1) Sensible @else @if($objAnalitica->escalapsdosbacte_id==2) Intermedio @else @if($objAnalitica->escalapsdosbacte_id==3) Resistente @else Sensibilidad disminuida a penicilina  @endif @endif @endif</span>
                                                    </th>
                                                </tr>
                                            @endif
                                            @if($objAnalitica->antibioticopstresbacte_id>0)
                                                <tr>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->antibioticopstresbacte->descripcion }}</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->halopstres_bacte }} mm.</span>
                                                    </th>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">@if($objAnalitica->escalapstresbacte_id==1) Sensible @else @if($objAnalitica->escalapstresbacte_id==2) Intermedio @else @if($objAnalitica->escalapstresbacte_id==3) Resistente @else Sensibilidad disminuida a penicilina  @endif @endif @endif</span>
                                                    </th>
                                                </tr>
                                            @endif
                                            @if($objAnalitica->antibioticopscuatrobacte_id>0)
                                                <tr>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->antibioticopscuatrobacte->descripcion }}</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->halopscuatro_bacte }} mm.</span>
                                                    </th>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">@if($objAnalitica->escalapscuatrobacte_id==1) Sensible @else @if($objAnalitica->escalapscuatrobacte_id==2) Intermedio @else @if($objAnalitica->escalapscuatrobacte_id==3) Resistente @else Sensibilidad disminuida a penicilina  @endif @endif @endif</span>
                                                    </th>
                                                </tr>
                                            @endif
                                            @if($objAnalitica->antibioticopscincobacte_id>0)
                                                <tr>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->antibioticopscincobacte->descripcion }}</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->halopscinco_bacte }} mm.</span>
                                                    </th>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">@if($objAnalitica->escalapscincobacte_id==1) Sensible @else @if($objAnalitica->escalapscincobacte_id==2) Intermedio @else @if($objAnalitica->escalapscincobacte_id==3) Resistente @else Sensibilidad disminuida a penicilina  @endif @endif @endif</span>
                                                    </th>
                                                </tr>
                                            @endif
                                            @if($objAnalitica->antibioticopsseisbacte_id>0)
                                                <tr>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->antibioticopsseisbacte->descripcion }}</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->halopsseis_bacte }} mm.</span>
                                                    </th>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">@if($objAnalitica->escalapsseisbacte_id==1) Sensible @else @if($objAnalitica->escalapsseisbacte_id==2) Intermedio @else @if($objAnalitica->escalapsseisbacte_id==3) Resistente @else Sensibilidad disminuida a penicilina  @endif @endif @endif</span>
                                                    </th>
                                                </tr>
                                            @endif
                                            @if($objAnalitica->antibioticomdunobacte_id>0)
                                                <tr>
                                                    <th colspan="9">
                                                        <span
                                                    class="text-dark-50 font-weight-bolder d-block font-size-lg">Métodos de Dilusión - Concentración Mínima Inhibitoria</span>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->antibioticomdunobacte->descripcion }}</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->cimmduno_bacte }} mm.</span>
                                                    </th>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">@if($objAnalitica->escalamdunobacte_id==1) Sensible @else @if($objAnalitica->escalamdunobacte_id==2) Intermedio @else Resistente @endif @endif</span>
                                                    </th>
                                                </tr>
                                            @endif
                                            @if($objAnalitica->antibioticomddosbacte_id>0)
                                                <tr>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->antibioticomddosbacte->descripcion }}</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->cimmddos_bacte }} mm.</span>
                                                    </th>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">@if($objAnalitica->escalamddosbacte_id==1) Sensible @else @if($objAnalitica->escalamddosbacte_id==2) Intermedio @else Resistente @endif @endif</span>
                                                    </th>
                                                </tr>
                                            @endif
                                            @if($objAnalitica->antibioticomdtresbacte_id>0)
                                                <tr>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->antibioticomdtresbacte->descripcion }}</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->cimmdtres_bacte }} mm.</span>
                                                    </th>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">@if($objAnalitica->escalamdtresbacte_id==1) Sensible @else @if($objAnalitica->escalamdtresbacte_id==2) Intermedio @else Resistente @endif @endif</span>
                                                    </th>
                                                </tr>
                                            @endif
                                            @if($objAnalitica->antibioticomdcuatrobacte_id>0)
                                                <tr>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->antibioticomdcuatrobacte->descripcion }}</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->cimmdcuatro_bacte }} mm.</span>
                                                    </th>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">@if($objAnalitica->escalamdcuatrobacte_id==1) Sensible @else @if($objAnalitica->escalamdcuatrobacte_id==2) Intermedio @else Resistente @endif @endif</span>
                                                    </th>
                                                </tr>
                                            @endif
                                        @endif
                                        @if($objAnalitica->crns_id==6)
                                            <tr>
                                                <th colspan="9">
                                                    Valores registrados durante el análisis técnico.
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="5">
                                                    <span
                                                    class="text-dark-50 font-weight-bolder d-block font-size-lg">Germen Aislado: {{ $objAnalitica->germenaislado_mico }}</span>
                                                </th>
                                                <th colspan="4">
                                                    <span
                                                    class="text-dark-50 font-weight-bolder d-block font-size-lg">Directo KOH: {{ $objAnalitica->directokoh_mico }}</span>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="5">
                                                    <span
                                                    class="text-dark-50 font-weight-bolder d-block font-size-lg">Directo Placa Teñida : {{ $objAnalitica->directoplaca_mico }}</span>
                                                </th>
                                                <th colspan="4">
                                                    <span
                                                    class="text-dark-50 font-weight-bolder d-block font-size-lg">Tinta China: {{ $objAnalitica->tintachina_mico }}</span>
                                                </th>
                                            </tr>
                                            @if($objAnalitica->deteccionunomico_id>0)
                                                <tr>
                                                    <th colspan="9">
                                                        <span
                                                    class="text-dark-50 font-weight-bolder d-block font-size-lg">Inmunodifusión - Detección de anticuerpos</span>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="4">
                                                        <span
                                                        class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->deteccionunomico->descripcion }} : @if($objAnalitica->interpretaunomico_id==1) Positivo @else Negativo @endif</span>
                                                    </th>
                                                    <th colspan="5">
                                                        <span
                                                        class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->detecciondosmico->descripcion }} : @if($objAnalitica->interpretadosmico_id==1) Positivo @else Negativo @endif</span>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="4">
                                                        <span
                                                        class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->detecciontresmico->descripcion }} : @if($objAnalitica->interpretatresmico_id==1) Positivo @else Negativo @endif</span>
                                                    </th>
                                                    <th colspan="5">
                                                        <span
                                                        class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->deteccioncuatromico->descripcion }} : @if($objAnalitica->interpretacuatromico_id==1) Positivo @else Negativo @endif</span>
                                                    </th>
                                                </tr>
                                            @endif
                                            @if($objAnalitica->antibiogramamico_id>0)
                                                <tr>
                                                    <tr>
                                                        <th colspan="9">
                                                            <span
                                                        class="text-dark-50 font-weight-bolder d-block font-size-lg">Antibiograma : {{ $objAnalitica->antibiogramamico->descripcion }}</span>
                                                        </th>
                                                    </tr>
                                                </tr>
                                            @endif
                                            @if($objAnalitica->fungicounomico_id>0)
                                                <tr>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">Antifúngico</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">CIM</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">Difusión</span>
                                                    </th>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">Interpretación</span>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->fungicounomico->descripcion }}</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->cimuno_mico }}</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->difusionuno_mico }}</span>
                                                    </th>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">@if($objAnalitica->escalaunomico_id==1) Sensible @else @if($objAnalitica->escalaunomico_id==2) Intermedio @else Resistente @endif @endif</span>
                                                    </th>
                                                </tr>
                                            @endif
                                            @if($objAnalitica->fungicodosmico_id>0)
                                                <tr>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->fungicodosmico->descripcion }}</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->cimdos_mico }}</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->difusiondos_mico }}</span>
                                                    </th>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">@if($objAnalitica->escaladosmico_id==1) Sensible @else @if($objAnalitica->escaladosmico_id==2) Intermedio @else Resistente @endif @endif</span>
                                                    </th>
                                                </tr>
                                            @endif
                                            @if($objAnalitica->fungicotresmico_id>0)
                                                <tr>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->fungicotresmico->descripcion }}</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->cimtres_mico }}</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->difusiontres_mico }}</span>
                                                    </th>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">@if($objAnalitica->escalatresmico_id==1) Sensible @else @if($objAnalitica->escalatresmico_id==2) Intermedio @else Resistente @endif @endif</span>
                                                    </th>
                                                </tr>
                                            @endif
                                            @if($objAnalitica->fungicocuatromico_id>0)
                                                <tr>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->fungicocuatromico->descripcion }}</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->cimcuatro_mico }}</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->difusioncuatro_mico }}</span>
                                                    </th>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">@if($objAnalitica->escalacuatromico_id==1) Sensible @else @if($objAnalitica->escalacuatromico_id==2) Intermedio @else Resistente @endif @endif</span>
                                                    </th>
                                                </tr>
                                            @endif
                                            @if($objAnalitica->fungicocincomico_id>0)
                                                <tr>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->fungicocincomico->descripcion }}</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->cimcinco_mico }}</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->difusioncinco_mico }}</span>
                                                    </th>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">@if($objAnalitica->escalacincomico_id==1) Sensible @else @if($objAnalitica->escalacincomico_id==2) Intermedio @else Resistente @endif @endif</span>
                                                    </th>
                                                </tr>
                                            @endif
                                            @if($objAnalitica->fungicoseismico_id>0)
                                                <tr>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->fungicoseismico->descripcion }}</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->cimseis_mico }}</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->difusionseis_mico }}</span>
                                                    </th>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">@if($objAnalitica->escalaseismico_id==1) Sensible @else @if($objAnalitica->escalaseismico_id==2) Intermedio @else Resistente @endif @endif</span>
                                                    </th>
                                                </tr>
                                            @endif
                                            @if($objAnalitica->fungicosietemico_id>0)
                                                <tr>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->fungicosietemico->descripcion }}</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->cimsiete_mico }}</span>
                                                    </th>
                                                    <th colspan="2">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">{{ $objAnalitica->difusionsiete_mico }}</span>
                                                    </th>
                                                    <th colspan="3">
                                                        <span class="text-dark-50 font-weight-bolder d-block font-size-lg">@if($objAnalitica->escalasietemico_id==1) Sensible @else @if($objAnalitica->escalasietemico_id==2) Intermedio @else Resistente @endif @endif</span>
                                                    </th>
                                                </tr>
                                            @endif
                                        @endif
                                        </tbody>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-row">
                                <br>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label class="text-black"><b>Resultado Cierre Caso</b><span class="text-danger">*</span></label>
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
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="text-black"><b>Observación Responsable de la validación</b></label>
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
                                            class="form-control form-control-solid @error('Analiticas.descripcion_responsable') is-invalid @enderror"
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
            @if ($Analiticas->resultado_id==67 && ($Analiticas->evento_id==116 || $Analiticas->evento_id==117 || $Analiticas->evento_id==118 || $Analiticas->evento_id==119 || $Analiticas->evento_id==120 || $Analiticas->evento_id==125))
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="text-black"><b>Generación Eventos para investigación ampliada</b><span class="text-danger">*</span></label>
                        <div class="input-group input-group-solid">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-list"></i>
                            </span>
                        </div>
                        <select
                            wire:model.defer="Analiticas.eventosav_id"
                            class="form-control selectpicker form-control-solid @error('Analiticas.eventosav_id') is-invalid @enderror"
                            data-size="7"
                            data-live-search="true"
                            data-show-subtext="true"
                            required multiple>
                            <option value="">Selecciona un Evento</option>
                            @foreach ($eventos as $objEvento)
                                <option data-subtext="" value="{{ $objEvento->id }}">{{ $objEvento->simplificado }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif
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
