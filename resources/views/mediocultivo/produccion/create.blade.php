@if(session('status'))
    <div class="alert alert-success mb-1 mt-1">
        {{ session('status') }}
    </div>
@endif
<div class="card card-custom">
    <div class="card-body">
        <form id="frmCrearRequerimiento" action="{{ route('requerimiento.store') }}" method="GET" enctype="multipart/form-data">
            @csrf
            

            <div class="form-row">
                <div class="form-group col-md-8">
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
                                    <option data-subtext="{{ $area->descripcion }}" value="{{ $area->id }}">{{ $area->nombre }}</option>
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
                <div class="form-group col-md-8">
                    <label for="inputSolicitante">Solicitante <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-user-check"></i>
                            </span>
                        </div>
                        <input id="txtSolicitanteRequer" name="txtSolicitanteRequer" type="text"
                        class="form-control form-control-solid" placeholder="Luis Dier Luque"/>
                    </div>
                    @error('txtSolicitanteRequer')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="inputMaterialRequer">Material Limpio y Estéril <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-magic"></i>
                            </span>
                        </div>
                        <input id="txtMaterialRequer" name="txtMaterialRequer" type="text"
                        class="form-control form-control-solid" placeholder="SI / NO"/>
                    </div>
                    @error('txtMaterialRequer')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="inputAuxiliarRequer">Auxiliar <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                        </div>
                        <input id="txtAuxiliarRequer" name="txtAuxiliarRequer" type="text"
                        class="form-control form-control-solid" placeholder="Kelvin Magallanes Conforme"/>
                    </div>
                    @error('txtAuxiliarRequer')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="inputCantCompRequer">Cantidad Completa <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-check-double"></i>
                            </span>
                        </div>
                        <input id="txtCantRequer" name="txtCantRequer" type="text"
                        class="form-control form-control-solid" placeholder="SI / NO"/>
                    </div>
                    @error('txtCantRequer')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="inputResponsableRequer">Responsable <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-user-tie"></i>
                            </span>
                        </div>
                        <input id="txtResponsableRequer" name="txtResponsableRequer" type="text"
                        class="form-control form-control-solid" placeholder="Henry Machuca Ruiz"/>
                    </div>
                    @error('txtResponsableRequer')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="inputEstado">Estado: </label>
                        <select
                            id="slcEstadoRequer" name="slcEstadoRequer"
                            wire:model.defer="registro_requerimiento.estado"
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

            <div class="form-row">
                <div class="form-group col-md-10">
                    <label for="inputProductos">Productos <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-cube"></i>
                            </span>
                            <select
                                id="slcProductoRequer" name="slcProductoRequer"
                                wire:model.defer="detalle_requerimiento.id_producto" 
                                class="form-control select2 form-control-solid"
                                data-size="7"
                                data-live-search="true"
                                data-show-subtext="true"
                                required>
                                <option value="">Selecciona el Producto</option>
                                @foreach ($producto as $prod)
                                    <option data-subtext="{{ $prod->descripcion }}" value="{{ $prod->id }}">{{ $prod->nombre .'--'. $prod->presentacion }}</option>
                                @endforeach
                            </select>
                            <span class="input-group-text">
                                <button type="button" id="agregaproducto" onclick="agregarproducto()">
                                    <i class="ace-icon fas fa-plus"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    @error('detalle_requerimiento.id_producto')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <input type="hidden" id="ListaPro" name="ListaPro" value="" required />
                <table id="TablaPro" class="table">
                    <thead>
                        <tr>
                            <th class="hidden">Id</th>
                            <th>Producto</th>
                            <th>Material</th>
                            <th>Volumen</th>
                            <th>Observación</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="ProSelected"><!--Ingreso un id al tbody-->
                        <tr>
                    
                        </tr>
                    </tbody>
                </table>
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
        width: '415px',
    });

    $('#slcProductoRequer').select2({
        width: '535px',
    });
</script>