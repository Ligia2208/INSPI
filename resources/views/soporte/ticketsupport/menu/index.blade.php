<div class="col-xl-12">
    <div class="card card-custom gutter-b">
        <div class="card-body pt-0 pb-3">
            <br>
        </div>
        <div class="card-body pt-0 pb-3">
            <div class="mb-5 ">
                <div class="row align-items-center">
                <!--begin::Nav-->
                    <div class="col-md-2 " align="center">
                            <a href="{{ route('ticketsupport.index') }}" class="navi-link py-4 {{ active('ticketsupport.index') }}">
                                <span class="navi-icon mr-2">
                                    <i class="fa fa-tags fa-3x"></i>
                                </span>
                                <span class="navi-text font-size-xl">Bandeja Tickets</span>
                            </a>
                        </div>
                        <div class="col-md-3 navi-item" align="center">
                            <a href="{{ route('ticketasignado.index') }}" class="navi-link py-4 {{ active('ticketasignado.index') }}">
                                <span class="navi-icon mr-2">
                                    <i class="fa fa-user fa-3x"></i>
                                </span>
                                <span class="navi-text font-size-xl">Tickets Asignados</span>
                            </a>
                        </div>
                        <div class="col-md-3 navi-item" align="center">
                            <a href="{{ route('ticketurgente.index') }}" class="navi-link py-4 {{ active('ticketurgente.index') }}">
                                <span class="navi-icon mr-2">
                                    <i class="fa fa-calendar fa-3x"></i>
                                </span>
                                <span class="navi-text font-size-xl">Tickets Urgentes</span>
                            </a>
                        </div>
                        <div class="col-md-3 navi-item" align="center">
                            <a href="{{ route('ticketseguimiento.index') }}" class="navi-link py-4 {{ active('ticketseguimiento.index') }}">
                                <span class="navi-icon mr-2">
                                    <i class="fa fa-gavel fa-3x"></i>
                                </span>
                                <span class="navi-text font-size-xl">Seguimiento</span>
                            </a>
                        </div>
                    </div>
                </div>
                <!--end::Nav-->
            <!--end::Body-->
        </div>
        <div class="card-body pt-0 pb-3">
            <div class="mb-5 ">
                <div class="row align-items-center">
                <!--begin::Nav-->
                    <div class="col-md-2 " align="center">
                            <a href="{{ route('ticketeliminado.index') }}" class="navi-link py-4 {{ active('ticketeliminado.index') }}">
                                <span class="navi-icon mr-2">
                                    <i class="fa fa-times fa-3x"></i>
                                </span>
                                <span class="navi-text font-size-xl">Tickets Eliminados</span>
                            </a>
                        </div>
                        <div class="col-md-3 navi-item" align="center">
                            <a href="{{ route('ticketsupport.index') }}" class="navi-link py-4 {{ active('ticketsupport.index') }}">
                                <span class="navi-icon mr-2">
                                    <i class="fa fa-signal fa-3x"></i>
                                </span>
                                <span class="navi-text font-size-xl">Estadisticas</span>
                            </a>
                        </div>
                        <div class="col-md-3 navi-item" align="center">
                            <a href="{{ route('ticketsupport.index') }}" class="navi-link py-4 {{ active('ticketsupport.index') }}">
                                <span class="navi-icon mr-2">
                                    <i class="fa fa-spinner fa-3x"></i>
                                </span>
                                <span class="navi-text font-size-xl">Reportes</span>
                            </a>
                        </div>
                        <div class="col-md-3 navi-item" align="center">
                            <a href="{{ route('tecnico.index') }}" class="navi-link py-4 {{ active('tecnico.index') }}">
                                <span class="navi-icon mr-2">
                                    <i class="fa fa-users fa-3x"></i>
                                </span>
                                <span class="navi-text font-size-xl">Técnicos de Soporte</span>
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


