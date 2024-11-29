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
                            <a href="{{ route('ticketuser.index') }}" class="navi-link py-4 {{ active('ticketuser.index') }}">
                                <span class="navi-icon mr-2">
                                    <i class="fa fa-tags fa-3x"></i>
                                </span>
                                <span class="navi-text font-size-xl">Tickets Nuevos</span>
                            </a>
                        </div>
                        <div class="col-md-3 navi-item" align="center">
                            <a href="{{ route('ticketusertramite.index') }}" class="navi-link py-4 {{ active('ticketusertramite.index') }}">
                                <span class="navi-icon mr-2">
                                    <i class="fa fa-cogs fa-3x"></i>
                                </span>
                                <span class="navi-text font-size-xl">Tickets en Trámite</span>
                            </a>
                        </div>
                        <div class="col-md-3 navi-item" align="center">
                            <a href="{{ route('ticketusercerrado.index') }}" class="navi-link py-4 {{ active('ticketusercerrado.index') }}">
                                <span class="navi-icon mr-2">
                                    <i class="fa fa-tasks fa-3x"></i>
                                </span>
                                <span class="navi-text font-size-xl">Tickets Cerrados</span>
                            </a>
                        </div>
                        <div class="col-md-3 navi-item" align="center">
                            <a href="" class="navi-link py-4 {{ active('user.log') }}">
                                <span class="navi-icon mr-2">
                                    <i class="fa fa-puzzle-piece fa-3x"></i>
                                </span>
                                <span class="navi-text font-size-xl">Instructivos</span>
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


