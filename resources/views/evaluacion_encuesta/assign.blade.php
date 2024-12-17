
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />
<!-- <script src="{{ asset('js/app.js') }}"></script> -->


<div class="row">
    <div class="col-xl-12 mx-auto">

        <div class="card">
            <div class="card-body">
                <div class="p-4 border rounded">
                    <form id="frmAssignDocumento" action="{{ route('gestion.storeassign') }}" method="post" class="row g-3 needs-validation " novalidate>
                        @csrf

                            <!-- <div class="col-md-6">
                                <label for="validationCustom01" class="form-label">Id Asignación</label> -->
                                <input type="hidden" id="id_asignacion" name="id_asignacion" class="form-control"  readonly="readonly" required="" value="{{ $asignacion->id_asignacion }}" autofocus>
                                <!-- <div class="valid-feedback">Looks good!</div>
                            </div> -->



                            <div class="col-md-12">
                                <label for="plazos" class="form-label">Plazo</label>
                                <input type="date" id="plazo" name="plazo" class="form-control  @error('plazo') is-invalid @enderror" required=""  autofocus ="">
                                <div class="valid-feedback">Looks good!</div>
                                @error('plazo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="coordina" class="form-label">Coordinación Zonal</label>
                                <select id="coordina" name="coordina" class="form-select single-select  @error('coordina') is-invalid @enderror" required="" autofocus="">
                                    <option value="">Seleccione la Coordinación</option>
                                    @foreach($coordina as $coor)
                                        <option value="{{ $coor->id}}"> {{ $coor->nombre}} </option>
                                    @endforeach
                                </select>
                                @error('coordina')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="departamentos" class="form-label">Departamento</label>
                                <select id="departamento" name="departamento" class="form-select single-select  @error('departamento') is-invalid @enderror" required="" autofocus="">
                                    <option value="">Seleccione un Departamento</option>
                                    @foreach($departamentos as $dep)
                                        <option value="{{ $dep->id}}"> {{ $dep->nombre}} </option>
                                    @endforeach
                                </select>
                                @error('departamento')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- <button type="submit" class="btn submit btn-primary btn-shadow font-weight-bold mr-2">
                                <span class="lni lni-save"></span>
                                Guardar
                            </button> -->

                    </form>
                </div>
            </div>
        </div>

<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script>

    /*
    $('.single-select').select2({
        dropdownParent: $('.modal-body'),
        theme: 'bootstrap4',
        width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
        placeholder: $(this).data('placeholder'),
        allowClear: Boolean($(this).data('allow-clear')),
    });
    */


    $(document).ready(function() {

        $('#coordina').on('change', function() {
            var selectedCoordina = $(this).val();

            // Realiza una solicitud AJAX para obtener las opciones de departamento
            $.ajax({
                type: 'GET', // O el método que estés utilizando en tu ruta
                url: '/obtenerDepartamentos/' + selectedCoordina, // Ruta en tu servidor para obtener las opciones
                success: function(data) {
                    var departamentoSelect = $('#departamento');
                    departamentoSelect.empty(); // Limpia las opciones actuales

                    // Agrega las nuevas opciones basadas en la respuesta del servidor
                    $.each(data, function(index, departamento) {
                        departamentoSelect.append($('<option>', {
                            value: departamento.id,
                            text: departamento.nombre
                        }));
                    });
                },
                error: function(error) {
                    console.error('Error al obtener opciones de departamento', error);
                }
            });


        });
    });

</script>
