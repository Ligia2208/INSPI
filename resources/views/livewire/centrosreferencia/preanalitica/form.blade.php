<div class="col-xl-12" x-data="app()">

    @section('head')
        <link rel="stylesheet" href="{{ asset('assets/plugins/custom/bfi/bfi.css') }}">
    @endsection

    <!--begin::Card-->
    <div class="card card-custom card-sticky" id="kt_page_sticky_card">
        <div class="card-body">
            <!--begin::Form-->
            <form class="form" wire:submit.prevent="{{ $method }}">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="my-5">
                            <a href="{{ route('preanalitica.index') }}"
                                class="navi-link py-4 {{ active('user.index') }}">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i aria-hidden="true" class="ki ki-bold-close icon-lg"></i>
                                </button>
                            </a>
                            <h3 class="text-dark font-weight-bold mb-10">Información general</h3>
                            @include('component.error-list')
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label>Institución de Salud<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticas.instituciones_id"
                                            wire:model="changedInstitucion"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticas.sedes_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona una Institución de Salud</option>
                                            @foreach ($instituciones as $objIns)
                                                <option
                                                    data-subtext="{{ $objIns->provincia->descripcion }} - {{ $objIns->canton->descripcion }}"
                                                    value="{{ $objIns->id }}">{{ $objIns->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Tipología IS<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.institucion_tipologia" type="text"
                                            required readonly
                                            class="form-control form-control-solid @error('Preanaliticas.institucion_tipologia') is-invalid @enderror"
                                            placeholder="Ej: MSP - IESS - SOLCA" />
                                    </div>
                                    @error('Preanaliticas.institucion_tipologia')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Denominación IS<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.institucion_nombre" type="text"
                                            required readonly
                                            class="form-control form-control-solid @error('Preanaliticas.institucion_nombre') is-invalid @enderror"
                                            placeholder="Ej: Teodoro Maldonado C." />
                                    </div>
                                    @error('Preanaliticas.institucion_nombre')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Tipología IS<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.institucion_tipologia" type="text"
                                            required readonly
                                            class="form-control form-control-solid @error('Preanaliticas.institucion_tipologia') is-invalid @enderror"
                                            placeholder="Ej: Centro de Salud Tipo A" />
                                    </div>
                                    @error('Preanaliticas.institucion_tipologia')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Nivel IS<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.institucion_nivel" type="text"
                                            required readonly
                                            class="form-control form-control-solid @error('Preanaliticas.institucion_nivel') is-invalid @enderror"
                                            placeholder="Ej: Nivel 1" />
                                    </div>
                                    @error('Preanaliticas.institucion_nivel')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Provincia - Cantón<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.institucion_ubicacion" type="text"
                                            required readonly
                                            class="form-control form-control-solid @error('Preanaliticas.institucion_ubicacion') is-invalid @enderror"
                                            placeholder="Ej: Guayas - Guayaquil" />
                                    </div>
                                    @error('Preanaliticas.institucion_ubicacion')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-1" >
                                    <label>Id<span class="text-danger"></span></label>
                                    <input wire:model.defer="Preanaliticas.paciente_id" type="text" required
                                        class="form-control form-control-solid @error('Preanaliticas.paciente_id') is-invalid @enderror"
                                        placeholder="Ej: 123" />
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Identificación Paciente<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.identidad"
                                            wire:model="changedIdentidad" type="text" required
                                            class="form-control form-control-solid @error('Preanaliticas.identidad') is-invalid @enderror"
                                            placeholder="Ej: 0900786523" />
                                    </div>
                                    @error('Preanaliticas.identidad')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Apellidos Paciente<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.paciente_apellidos" type="text"
                                            required
                                            class="form-control form-control-solid @error('Preanaliticas.paciente_apellidos') is-invalid @enderror"
                                            placeholder="Ej: Jácome Castro" />
                                    </div>
                                    @error('Preanaliticas.paciente_apellidos')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Nombres Paciente<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.paciente_nombres" type="text"
                                            required
                                            class="form-control form-control-solid @error('Preanaliticas.paciente_nombres') is-invalid @enderror"
                                            placeholder="Ej: Fernanda Lorena" />
                                    </div>
                                    @error('Preanaliticas.paciente_nombres')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Sexo<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticas.paciente_sexo"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticas.paciente_sexo') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona Sexo</option>
                                            @foreach ($sexos as $objSex)
                                                <option data-subtext="" value="{{ $objSex->id }}">
                                                    {{ $objSex->descripcion }}</option>
                                            @endforeach
                                        </select>
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
                                        <input wire:model.defer="Preanaliticas.paciente_fechanac"
                                            value="Preanaliticas.paciente_fechanac" type="date"
                                            class="start_date form-control form-control-solid @error('Preanaliticas.paciente_fechanac') is-invalid @enderror"
                                            placeholder="Seleccione la fecha nacimiento" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Dirección<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.paciente_direccion" type="text"
                                            required
                                            class="form-control form-control-solid @error('Preanaliticas.paciente_direccion') is-invalid @enderror"
                                            placeholder="Ej: Urdesa Central" />
                                    </div>
                                    @error('Preanaliticas.paciente_direccion')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Teléfono<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.paciente_telefono" type="text"
                                            required
                                            class="form-control form-control-solid @error('Preanaliticas.paciente_telefono') is-invalid @enderror"
                                            placeholder="Ej: 0998253411" />
                                    </div>
                                    @error('Preanaliticas.paciente_telefono')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Ubicación<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticas.paciente_ubicacion"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticas.paciente_ubicacion') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona Cantón</option>
                                            @foreach ($cantonprov as $objCanton)
                                                <option data-subtext="{{ $objCanton->provincia->descripcion }}" value="{{ $objCanton->id }}">
                                                    {{ $objCanton->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Preanaliticas.paciente_ubicacion')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Nacionalidad<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticas.paciente_nacionalidad"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticas.paciente_nacionalidad') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona Nacionalidad</option>
                                            @foreach ($nacionalidades as $objNacion)
                                                <option data-subtext="" value="{{ $objNacion->id }}">
                                                    {{ $objNacion->nacionalidad }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('Preanaliticas.paciente_nacionalidad')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label>Fecha de atención<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.fecha_atencion"
                                            value="Preanaliticas.fecha_atencion" type="date"
                                            class="start_date form-control form-control-solid @error('Preanaliticas.fecha_atencion') is-invalid @enderror"
                                            placeholder="Seleccione la fecha de atención" />
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Nombre de quien notifica<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.quien_notifica" type="text" required
                                            class="form-control form-control-solid @error('Preanaliticas.quien_notifica') is-invalid @enderror"
                                            placeholder="Ej: Dr. Julio Robles" />
                                    </div>
                                    @error('Preanaliticas.quien_notifica')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Lugar probable infección<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.probable_infeccion" type="text"
                                            required
                                            class="form-control form-control-solid @error('Preanaliticas.probable_infeccion') is-invalid @enderror"
                                            placeholder="Ej: Sur de la ciudad" />
                                    </div>
                                    @error('Preanaliticas.probable_infeccion')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label>Fecha Inicio Síntomas<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.fecha_sintomas"
                                            value="Preanaliticas.fecha_sintomas" type="date"
                                            class="start_date form-control form-control-solid @error('Preanaliticas.fecha_sintomas') is-invalid @enderror"
                                            placeholder="Seleccione la fecha de inicio sintomas" />
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
                                        <input wire:model.defer="Preanaliticas.evolucion" type="numeric" value=0
                                            class="form-control form-control-solid @error('Preanaliticas.evolucion') is-invalid @enderror"
                                            placeholder="Ej: 8" />
                                    </div>
                                    @error('Preanaliticas.evolucion')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-1">
                                    <label>Embarazo<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticas.embarazo"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticas.embarazo') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona opción</option>
                                            <option data-subtext="" value="1">Si</option>
                                            <option data-subtext="" value="2">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Semanas Gestación<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.gestacion" type="numeric"
                                            class="form-control form-control-solid @error('Preanaliticas.gestacion') is-invalid @enderror"
                                            placeholder="Ej: 8" />
                                    </div>
                                    @error('Preanaliticas.gestacion')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Muestra de Laboratorio<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticas.laboratorio"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticas.laboratorio') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona opción</option>
                                            <option data-subtext="" value="1">Si</option>
                                            <option data-subtext="" value="2">No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Nombre Laboratorio<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.nombre_laboratorio" type="text"
                                            class="form-control form-control-solid @error('Preanaliticas.nombre_laboratorio') is-invalid @enderror"
                                            placeholder="Ej: Interlab" />
                                    </div>
                                    @error('Preanaliticas.nombre_laboratorio')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Sede<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticas.sedes_id" wire:model="selectedSedep"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticas.sedes_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona una Sede</option>
                                            @foreach ($sedes as $objSed)
                                                <option data-subtext="" value="{{ $objSed->id }}">
                                                    {{ $objSed->descripcion }}</option>
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
                                        <select wire:model.defer="Preanaliticas.crns_id"
                                            wire:model.live="selectedCrnp"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticas.crns_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona un CRN</option>
                                            @if (!is_null($crns))
                                                @foreach ($crns as $objCrn)
                                                    <option data-subtext="" value="{{ $objCrn->id }}">
                                                        {{ $objCrn->descripcion }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label>Evento<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticas.evento_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticas.evento_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona un Evento</option>
                                            @if (!is_null($eventos))
                                                @foreach ($eventos as $objEvento)
                                                    <option data-subtext="{{ $objEvento->descripcion }}"
                                                        value="{{ $objEvento->id }}">{{ $objEvento->simplificado }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label>Muestra Principal<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticas.primera_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticas.primera_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true" required>
                                            <option value="">Selecciona un tipo muestra</option>
                                            @foreach ($muestras as $objMuestra)
                                                <option data-subtext="" value="{{ $objMuestra->id }}">
                                                    {{ $objMuestra->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Fecha Toma de muestra<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.fecha_toma_primera"
                                            value="Preanaliticas.fecha_toma_primera" type="date"
                                            class="start_date form-control form-control-solid @error('Preanaliticas.fecha_toma_primera') is-invalid @enderror"
                                            placeholder="Seleccione la fecha de inicio sintomas" />
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Estado Muestra<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticas.estado_primera_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticas.estado_primera_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true">
                                            <option value="">Selecciona estado muestra</option>
                                            @foreach ($estados as $objEstados)
                                                <option data-subtext="" value="{{ $objEstados->id }}">
                                                    {{ $objEstados->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Observación Muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.observacion_primera" type="text"
                                            class="form-control form-control-solid @error('Preanaliticas.observacion_primera') is-invalid @enderror"
                                            placeholder="Ej: Rechazo por volumen" />
                                    </div>
                                    @error('Preanaliticas.observacion_primera')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                &nbsp;&nbsp;
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i aria-hidden="true" class="fa fa-plus icon-lg" onclick="ver_ocultar()"
                                        title="Agregar mas muestras"></i>
                                </button>
                            </div>
                            <div class="form-row" id="add_muestras" style="visibility:hidden">
                                <div class="form-group col-md-3">
                                    <label>Muestra 2<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticas.segunda_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticas.segunda_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true">
                                            <option value="0">Selecciona un tipo muestra</option>
                                            @foreach ($muestras as $objMuestra)
                                                <option data-subtext="" value="{{ $objMuestra->id }}">
                                                    {{ $objMuestra->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Fecha Toma de muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.fecha_toma_segunda"
                                            value="Preanaliticas.fecha_toma_segunda" type="date"
                                            class="start_date form-control form-control-solid @error('Preanaliticas.fecha_toma_segunda') is-invalid @enderror"
                                            placeholder="Seleccione la fecha de inicio sintomas" />
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Estado Muestra<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticas.estado_segunda_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticas.estado_segunda_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true">
                                            <option value="">Selecciona estado muestra</option>
                                            @foreach ($estados as $objEstados)
                                                <option data-subtext="" value="{{ $objEstados->id }}">
                                                    {{ $objEstados->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Observación Muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.observacion_segunda" type="text"
                                            class="form-control form-control-solid @error('Preanaliticas.observacion_segunda') is-invalid @enderror"
                                            placeholder="Ej: Rechazo por volumen" />
                                    </div>
                                    @error('Preanaliticas.observacion_segunda')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Muestra 3<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticas.tercera_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticas.tercera_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true">
                                            <option value="0">Selecciona un tipo muestra</option>
                                            @foreach ($muestras as $objMuestra)
                                                <option data-subtext="" value="{{ $objMuestra->id }}">
                                                    {{ $objMuestra->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Fecha Toma de muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.fecha_toma_tercera"
                                            value="Preanaliticas.fecha_toma_tercera" type="date"
                                            class="start_date form-control form-control-solid @error('Preanaliticas.fecha_toma_tercera') is-invalid @enderror"
                                            placeholder="Seleccione la fecha de inicio sintomas" />
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Estado Muestra<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticas.estado_tercera_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticas.estado_tercera_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true">
                                            <option value="">Selecciona estado muestra</option>
                                            @foreach ($estados as $objEstados)
                                                <option data-subtext="" value="{{ $objEstados->id }}">
                                                    {{ $objEstados->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Observación Muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.observacion_tercera" type="text"
                                            class="form-control form-control-solid @error('Preanaliticas.observacion_tercera') is-invalid @enderror"
                                            placeholder="Ej: Rechazo por volumen" />
                                    </div>
                                    @error('Preanaliticas.observacion_tercera')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Muestra 4<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticas.cuarta_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticas.cuarta_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true">
                                            <option value="0">Selecciona un tipo muestra</option>
                                            @foreach ($muestras as $objMuestra)
                                                <option data-subtext="" value="{{ $objMuestra->id }}">
                                                    {{ $objMuestra->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Fecha Toma de muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.fecha_toma_cuarta"
                                            value="Preanaliticas.fecha_toma_cuarta" type="date"
                                            class="start_date form-control form-control-solid @error('Preanaliticas.fecha_toma_cuarta') is-invalid @enderror"
                                            placeholder="Seleccione la fecha de inicio sintomas" />
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Estado Muestra<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticas.estado_cuarta_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticas.estado_cuarta_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true">
                                            <option value="">Selecciona estado muestra</option>
                                            @foreach ($estados as $objEstados)
                                                <option data-subtext="" value="{{ $objEstados->id }}">
                                                    {{ $objEstados->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Observación Muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.observacion_cuarta" type="text"
                                            class="form-control form-control-solid @error('Preanaliticas.observacion_cuarta') is-invalid @enderror"
                                            placeholder="Ej: Rechazo por volumen" />
                                    </div>
                                    @error('Preanaliticas.observacion_cuarta')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Muestra 5<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticas.quinta_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticas.quinta_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true">
                                            <option value="">Selecciona un tipo muestra</option>
                                            @foreach ($muestras as $objMuestra)
                                                <option data-subtext="" value="{{ $objMuestra->id }}">
                                                    {{ $objMuestra->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Fecha Toma de muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.fecha_toma_quinta"
                                            value="Preanaliticas.fecha_toma_quinta" type="date"
                                            class="start_date form-control form-control-solid @error('Preanaliticas.fecha_toma_quinta') is-invalid @enderror"
                                            placeholder="Seleccione la fecha de inicio sintomas" />
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Estado Muestra<span class="text-danger">*</span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-list"></i>
                                            </span>
                                        </div>
                                        <select wire:model.defer="Preanaliticas.estado_quinta_id"
                                            class="form-control selectpicker form-control-solid @error('Preanaliticas.estado_quinta_id') is-invalid @enderror"
                                            data-size="7" data-live-search="true" data-show-subtext="true">
                                            <option value="">Selecciona estado muestra</option>
                                            @foreach ($estados as $objEstados)
                                                <option data-subtext="" value="{{ $objEstados->id }}">
                                                    {{ $objEstados->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Observación Muestra<span class="text-danger"></span></label>
                                    <div class="input-group input-group-solid">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-edit"></i>
                                            </span>
                                        </div>
                                        <input wire:model.defer="Preanaliticas.observacion_quinta" type="text"
                                            class="form-control form-control-solid @error('Preanaliticas.observacion_quinta') is-invalid @enderror"
                                            placeholder="Ej: Rechazo por volumen" />
                                    </div>
                                    @error('Preanaliticas.observacion_quinta')
                                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <button class="d-none" type="submit"></button>
            </form>
            <!--end::Form-->
        </div>
        <div class="card-header">
            <div class="card-toolbar">
                <button wire:click="{{ $method }}" wire:loading.class="spinner spinner-white spinner-right"
                    wire:target="{{ $method }}" class="btn btn-primary font-weight-bolder mr-2">
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
                        bfi_clear('#' + fileId);
                    },
                }
            }

            Livewire.on('renderJs', function() {
                $('.selectpicker').selectpicker({
                    liveSearch: true
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
