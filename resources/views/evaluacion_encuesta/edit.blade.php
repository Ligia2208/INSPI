
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />
<!-- <script src="{{ asset('js/app.js') }}"></script> -->


<div class="row">
    <div class="col-xl-12 mx-auto">

        <div class="card">
            <div class="card-body">
                <div class="p-4 border rounded">
                    <form id="frmEditDocumento" action="{{ route('gestion.storedit') }}" method="post" class="row g-3 needs-validation " novalidate>
                        @csrf

                            <input type="hidden" id="id_documento" name="id_documento" class="form-control"  readonly="readonly" required="" value="{{ $documento->id_documento }}" autofocus>

                            <div class="col-md-12">
                                <label for="nombre" class="form-label"> Número de Documento </label>
                                <input type="text" value="{{$documento->nombre}}" id="nombre" name="nombre" class="form-control  @error('nombre') is-invalid @enderror" required=""  autofocus ="">
                                <div class="valid-feedback">Looks good!</div>
                                @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="asunto" class="form-label"> Asúnto </label>
                                <input type="text" value="{{$documento->asunto}}" id="asunto" name="asunto" class="form-control  @error('asunto') is-invalid @enderror" required=""  autofocus ="">
                                <div class="valid-feedback">Looks good!</div>
                                @error('asunto')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="fecha" class="form-label"> Fecha del Documento </label>
                                <input type="date"  id="fecha" name="fecha" class="form-control  @error('fecha') is-invalid @enderror" required=""  autofocus ="">
                                <div class="valid-feedback">Looks good!</div>
                                @error('fecha')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="tipo" class="form-label">Tipo de documento</label>
                                <select id="tipo" name="tipo" class="form-select single-select  @error('tipo') is-invalid @enderror" required="" autofocus="">
                                    <option value="">Seleccione la Coordinación</option>
                                    @foreach($tipoDocumento as $tipo)
                                        <!-- <option value="{{ $tipo->Id_tipoDocumento}}"> {{ $tipo->nombre}} </option> -->
                                        <option value="{{ $tipo->Id_tipoDocumento }}" {{ $tipo->Id_tipoDocumento == $documento->tipo ? 'selected' : '' }}>
                                            {{ $tipo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                    </form>
                </div>
            </div>
        </div>

<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script>


    $(document).ready(function() {

        let fechaDocumento;

        if (!fechaDocumento) {
            // Obtiene la fecha del documento en el formato YYYY-MM-DD
            fechaDocumento = '{{ substr($documento->fecha, 0, 10) }}';
            // Asigna la fecha al input de fecha
            document.getElementById('fecha').value = fechaDocumento;
        }

    });

</script>
