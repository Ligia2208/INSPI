@if(session('status'))
    <div class="alert alert-success mb-1 mt-1">
        {{ session('status') }}
    </div>
@endif
<div class="card card-custom">
    <div class="card-body">
        <form id="frmEditarRequerimiento" action="{{ route('requerimiento.update',$post) }}" method="GET" enctype="multipart/form-data">
            @csrf

            @method('PUT')

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputId">Id: </label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-angle-double-right"></i>
                            </span>
                        </div>
                        <input id="txtIdRequer" name="txtIdRequer" type="text" class="form-control form-control-solid" value="{{ $post }}"  readonly="readonly"/>
                    </div>
                    @error('txtIdRequer')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="inputId">Fecha Solicitud: </label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-angle-double-right"></i>
                            </span>
                        </div>
                        <input id="txtFechaRequer" name="txtFechaRequer" type="text" class="form-control form-control-solid" readonly="readonly"/>
                    </div>
                    @error('txtFechaRequer')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="inputId">Hora Solicitud: </label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-angle-double-right"></i>
                            </span>
                        </div>
                        <input id="txtHoraRequer" name="txtHoraRequer" type="text" class="form-control form-control-solid" readonly="readonly"/>
                    </div>
                    @error('txtHoraRequer')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="inputArea">Área Solicitante <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-kaaba"></i>
                            </span>
                            <select
                                id="slcAreaRequer" name="slcAreaRequer"
                                wire:model.defer="registro_requerimiento.id_area" 
                                class="form-control select2 form-control-solid"
                                data-size="7"
                                data-live-search="true"
                                data-show-subtext="true"
                                required>
                                <option value="">Selecciona el Área Solicitante</option>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @error('registro_requerimiento.id_area')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputPedidoRequer">Número Pedido <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-code"></i>
                            </span>
                        </div>
                        <input id="txtNumPedidoRequer" name="txtNumPedidoRequer" type="text" class="form-control form-control-solid" />
                    </div>
                    @error('txtNumPedidoRequer')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-8">
                    <label for="inputSolicitanteRequer">Solicitante <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-id-card"></i>
                            </span>
                        </div>
                        <input id="txtSolicitanteRequer" name="txtSolicitanteRequer" type="text" class="form-control form-control-solid" />
                    </div>
                    @error('txtSolicitanteRequer')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputAuxiliarRequer">Auxiliar <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-id-card"></i>
                            </span>
                        </div>
                        <input id="txtAuxiliarRequer" name="txtAuxiliarRequer" type="text" class="form-control form-control-solid" />
                    </div>
                    @error('txtAuxiliarRequer')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            
                <div class="form-group col-md-6">
                    <label for="inputResponsableRequer">Responsable <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-id-card"></i>
                            </span>
                        </div>
                        <input id="txtResponsableRequer" name="txtResponsableRequer" type="text" class="form-control form-control-solid" />
                    </div>
                    @error('txtResponsableRequer')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEstado">Estado: </label>
                        <select
                            id="slcEstadoRequer" name="slcEstadoRequer"
                            wire:model.defer="productos.estado"
                            class="form-control select2 form-control-solid"
                            data-size="7"
                            data-live-search="true"
                            data-show-subtext="true"
                            required>
                            <option  value="0">Selecciona un Tipo</option>
                            @foreach ($tipoestado as $est)
                                <option  value="{{ $est->valor }}">{{ $est->descripcion }}</option>
                            @endforeach
                        </select>
                    @error('estado')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $('.select2').select2({
        //placeholder: "Select a State",
        allowClear: true,
        width: '100%'
    });

    $('#slcAreaRequer').select2({
        width: '650px',
    });
</script>