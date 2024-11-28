
<!--begin::Wrapper-->
<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
    <!--begin::Header-->
    <div id="kt_header" class="header header-fixed">
        <!--begin::Container-->
        <div class="container-fluid d-flex align-items-stretch justify-content-between">


            <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                <!--begin::Header Menu-->
                <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
                    <!--begin::Header Nav-->
                    <ul class="menu-nav">
                        <li class="menu-item menu-item-submenu menu-item-rel menu-item-active menu-item-open-dropdown" data-menu-toggle="click" aria-haspopup="true">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <span class="menu-text"><i class="fa fa-plus mr-2"></i> Acceder</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                                <ul class="menu-subnav">                         
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="https://mail.inspi.gob.ec" class="menu-link" target="_blank">
                                            <span class="svg-icon menu-icon">
                                                <i class="fa fa-envelope"></i>
                                            </span>
                                            <span class="menu-text">Correo Electrónico</span>
                                        </a>
                                    </li>
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="https://www.gestiondocumental.gob.ec/login.php" class="menu-link" target="_blank">
                                            <span class="svg-icon menu-icon">
                                                <i class="fa fa-newspaper"></i>
                                            </span>
                                            <span class="menu-text">Quipux</span>
                                        </a>
                                    </li>
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="http://www.investigacionsalud.gob.ec" class="menu-link" target="_blank">
                                            <span class="svg-icon menu-icon">
                                                <i class="fa fa-globe"></i>
                                            </span>
                                            <span class="menu-text">Sitio Web</span>
                                        </a>
                                    </li>
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="https://www.inspilip.gob.ec" class="menu-link" target="_blank">
                                            <span class="svg-icon menu-icon">
                                                <i class="fa fa-book"></i>
                                            </span>
                                            <span class="menu-text">Revista INSPILIP</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <!--end::Header Nav-->
                </div>
                <!--end::Header Menu-->
            </div>
            <!--begin::Topbar-->
            <div class="topbar">

                @livewire('layouts.rightsidebar.search')

                @livewire('layouts.rightsidebar.profile')

            </div>
            <!--end::Topbar-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Header-->

    @yield('content')

    @include('layouts.footer')

</div>
<!--end::Wrapper-->