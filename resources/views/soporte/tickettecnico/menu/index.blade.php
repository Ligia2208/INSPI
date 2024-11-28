<div class="col-xl-12">
    <div class="card card-custom gutter-b">
        <div class="card-body pt-0 pb-3">
            <br>
        </div>
        <div class="card-body pt-0 pb-3">
            <div class="mb-5 ">
                <div class="row align-items-center">
                <!--begin::Nav-->
                    <div class="col-md-3 navi-item" align="center">
                        <a href="{{ route('tickettecnico.index') }}" class="navi-link py-4 {{ active('tickettecnico.index') }}">
                            <span class="navi-icon mr-2">
                                <i class="fa fa-cogs fa-3x"></i>
                            </span>
                            <span class="navi-text font-size-xl">Tickets en Trámite</span>
                        </a>
                    </div>
                    <div class="col-md-3 navi-item" align="center">
                        <a href="{{ route('tickettecnicocerrado.index') }}" class="navi-link py-4 {{ active('tickettecnicocerrado.index') }}">
                            <span class="navi-icon mr-2">
                                <i class="fa fa-tasks fa-3x"></i>
                            </span>
                            <span class="navi-text font-size-xl">Tickets Cerrados</span>
                        </a>
                    </div>
                    <div class="col-md-3 navi-item" align="center">
                        <a href="" class="navi-link py-4 {{ active('estadisticas.index') }}">
                            <span class="navi-icon mr-2">
                                <i class="fa fa-signal fa-3x"></i>
                            </span>
                            <span class="navi-text font-size-xl">Estadísticas</span>
                        </a>
                    </div>
                    <div class="col-md-3 navi-item" align="center">
                        <a href="" class="navi-link py-4 {{ active('reportes.index') }}">
                            <span class="navi-icon mr-2">
                                <i class="fa fa-tags fa-3x"></i>
                            </span>
                            <span class="navi-text font-size-xl">Reportes</span>
                        </a>
                    </div>
                </div>
            </div>
                <!--end::Nav-->
            <!--end::Body-->
        </div>
<!--end::Profile Card-->
<!--end::Aside-->
    </div>
</div>


