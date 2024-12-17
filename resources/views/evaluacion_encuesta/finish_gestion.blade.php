
<!-- <script src="{{asset('assets/js/GestionDocumental/initGestionDocumental.js?V0.0.58')}}"></script> -->


<div class="card">
    <!-- <div class="card-header">
        Detalles del Documento
    </div> -->
    <div class="card-body">

        @foreach($data as $asig)

        <div class="row">
            <h5 class="card-title">{{ $asig->nombre }}</h5>
            <hr>

            <div class="col-6">
                <p class="card-text"><strong>Tipo:</strong> <span class="text-muted">{{ $asig->tipo }}</span></p>
                <p class="card-text"><strong>Estado:</strong>
                    @if($asig->estado == 'F')
                        <span class="badge bg-success text-center">Finalizado</span>
                    @endif
                </p>
                <p class="card-text"><strong>Fecha del Documento:</strong> <span class="text-muted">{{ $asig->fecha }}</span></p>
                <p class="card-text"><strong>Usuario:</strong> <span class="text-muted">{{ $asig->nameUser }}</span></p>


            </div>

            <div class="col-6">
                <p class="card-text"><strong>Plazo:</strong> <span class="text-muted">{{ $asig->f_plazo }}</span></p>
                <p class="card-text"><strong>Días Faltantes:</strong> <span class="text-muted">{{ $asig->dias_faltantes }}</span></p>

            </div>

            <div class="col-12 mt-3">
                <p class="card-text"><strong>Cargo:</strong> <span class="text-muted">{{ $asig->cargo }}</span></p>
                <!-- <p class="card-text"><strong>Área:</strong> <span class="text-muted">{{ $asig->id_area }}</span></p> -->
                <p class="card-text"><strong>Asignado a:</strong> <span class="text-muted">{{ $asig->asignado }}</span></p>
                <p class="card-text"><strong>Correo:</strong> <span class="text-muted"> {{ $asig->correo }} </span></p>

            </div>

            <div class="col-12 mt-5">

                <hr>
                <p class="card-text"> <span class="text-muted fs-6">El seguimiento fue finalizado con el memorándum: </span> <strong> {{ $asig->comentario }} </strong> </p>

            </div>

            <div class="text-center mt-3">
                <input type="hidden" id="id_asignacion" name="id_asignacion" class="form-control" readonly="readonly" required="" value="{{$asig->id_asignacion}}" autofocus="">

                <a type="button" class="btn submit btn-primary btn-shadow font-weight-bold me-2" id="btnAprobar">
                    <i class="fadeIn animated bx bx-send text-light"></i>
                    Aprobar
                </a>

            </div>

        </div>

        @endforeach

    </div>
</div>





