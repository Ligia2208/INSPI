@if(session('status'))
    <div class="alert alert-success mb-1 mt-1">
        {{ session('status') }}
    </div>
@endif
<div class="card card-custom">
    <div class="card-body">
        <form id="frmEditarProducto" action="{{ route('producto.update',$post) }}" method="GET" enctype="multipart/form-data">
            @csrf

            @method('PUT')

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputId">Id: </label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-angle-double-right"></i>
                            </span>
                        </div>
                        <input id="txtIdProducto" name="txtIdProducto" type="text" class="form-control form-control-solid" value="{{ $post }}"  readonly="readonly"/>
                    </div>
                    @error('txtIdProducto')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputCodigo">Código <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-code"></i>
                            </span>
                        </div>
                        <input id="txtCodigoProducto" name="txtCodigoProducto" type="text"
                        class="form-control form-control-solid" placeholder="Ej: FS-MDC-001"/>
                    </div>
                    @error('txtCodigoProducto')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-8">
                    <label for="inputNombre">Nombre <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-id-card"></i>
                            </span>
                        </div>
                        <input id="txtNombreProducto" name="txtNombreProducto" type="text"
                        class="form-control form-control-solid" placeholder="Ej: Medio Ogawa Kudoh o Medio OK"/>
                    </div>
                    @error('txtNombreProducto')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputAlmacenamiento">Almacenamiento <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-archive"></i>
                            </span>
                        </div>
                        <input id="txtAlmacenProducto" name="txtAlmacenProducto" type="text"
                        class="form-control form-control-solid" placeholder="Ej: EMPAQUETADOS EN PAPEL DE EMPAQUE"/>
                    </div>
                    @error('txtAlmacenProducto')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="inputColor">Color <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-palette"></i>
                            </span>
                        </div>
                        <input id="txtColorProducto" name="txtColorProducto" type="text"
                        class="form-control form-control-solid" placeholder="Ej: VERDE"/>
                    </div>
                    @error('txtColorProducto')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="inputConsistencia">Consistencia <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fab fa-react"></i>
                            </span>
                        </div>
                        <input id="txtConsistenciaProducto" name="txtConsistenciaProducto" type="text"
                        class="form-control form-control-solid" placeholder="Ej: SOLIDO"/>
                    </div>
                    @error('txtConsistenciaProducto')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputEsterilizacion">Esterilización <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-shower"></i>
                            </span>
                        </div>
                        <input id="txtEsteriliProducto" name="txtEsteriliProducto" type="text"
                        class="form-control form-control-solid" placeholder="Ej: AUTOCLAVE, FILTRACION"/>
                    </div>
                    @error('txtEsteriliProducto')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="inputTemperatura">Temperatura <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-temperature-high"></i>
                            </span>
                        </div>
                        <input id="txtTemperaturaProducto" name="txtTemperaturaProducto" type="text"
                        class="form-control form-control-solid" placeholder="Ej: 121"/>
                    </div>
                    @error('txtTemperaturaProducto')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="inputPresion">Presión <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-compress"></i>
                            </span>
                        </div>
                        <input id="txtPresionProducto" name="txtPresionProducto" type="text"
                        class="form-control form-control-solid" placeholder="Ej: 15"/>
                    </div>
                    @error('txtPresionProducto')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="inputTiempo">Tiempo <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-clock"></i>
                            </span>
                        </div>
                        <input id="txtTiempoProducto" name="txtTiempoProducto" type="text"
                        class="form-control form-control-solid" placeholder="Ej: 15"/>
                    </div>
                    @error('txtTiempoProducto')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputCaducidad">Fecha Caducidad <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-exclamation-circle"></i>
                            </span>
                        </div>
                        <input id="txtCaducidadProducto" name="txtCaducidadProducto" type="text"
                        class="form-control form-control-solid" placeholder="Ej: 2 MESES"/>
                    </div>
                    @error('txtCaducidadProducto')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="inputLote">Lote <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-list-alt"></i>
                            </span>
                        </div>
                        <input id="txtLoteProducto" name="txtLoteProducto" type="text"
                        class="form-control form-control-solid" placeholder="Ej: AC1N"/>
                    </div>
                    @error('txtLoteProducto')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="inputPh">Ph <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-sort-numeric-down"></i>
                            </span>
                        </div>
                        <input id="txtPhProducto" name="txtPhProducto" type="text"
                        class="form-control form-control-solid" placeholder="Ej: 8.6 ± 0.2"/>
                    </div>
                    @error('txtPhProducto')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="inputTempConserv">Temp. Conservación <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-temperature-low"></i>
                            </span>
                        </div>
                        <input id="txtTempConservProducto" name="txtTempConservProducto" type="text"
                        class="form-control form-control-solid" placeholder="Ej: 2 a 8°C"/>
                    </div>
                    @error('txtTempConservProducto')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputPresentacion">Presentación <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-vials"></i>
                            </span>
                        </div>
                        <input id="txtPresentacionProducto" name="txtPresentacionProducto" type="text"
                        class="form-control form-control-solid" placeholder="Ej: TUBOS 150X20 TAPA ROSCA"/>
                    </div>
                    @error('txtPresentacionProducto')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="inputRegProduccion">Registro Producción <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-wrench"></i>
                            </span>
                        </div>
                        <input id="txtRegProduccionProducto" name="txtRegProduccionProducto" type="text"
                        class="form-control form-control-solid" placeholder="Ej: F-MDC-006"/>
                    </div>
                    @error('txtRegProduccionProducto')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="inputCtrlEsteril">Control Esterilidad <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                        <input id="txtCtrlEsterilProducto" name="txtCtrlEsterilProducto" type="text"
                        class="form-control form-control-solid" placeholder="Ej: SI / NO"/>
                    </div>
                    @error('txtCtrlEsterilProducto')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputCtrlMicrobio">Control Microbiológico <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-eye-slash"></i>
                            </span>
                        </div>
                        <input id="txtCtrlMicrobioProducto" name="txtCtrlMicrobioProducto" type="text"
                        class="form-control form-control-solid" placeholder="Ej: SI / NO"/>
                    </div>
                    @error('txtCtrlMicrobioProducto')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-3">
                    <label for="inputCertificado">Certificado <span class="text-danger">*</label>
                    <div class="input-group input-group-solid">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-certificate"></i>
                            </span>
                        </div>
                        <input id="txtCertificadoProducto" name="txtCertificadoProducto" type="text"
                        class="form-control form-control-solid" placeholder="Ej: SI / NO"/>
                    </div>
                    @error('txtCertificadoProducto')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="inputEstado">Estado: </label>
                        <select
                            id="slcEstadoProducto" name="slcEstadoProducto"
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
</script>