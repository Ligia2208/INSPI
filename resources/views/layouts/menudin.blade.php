<!--begin::Aside Menu-->
<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
    <!--begin::Menu Container-->
    <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
        <!--begin::Menu Nav-->
        <ul class="menu-nav">
        @forelse ($menues as $objMen)
            @if($objMen->tipo=='MENU')
            <li class="menu-section">
                <h4 class="menu-text">{{$objMen->titulo}}</h4>
                <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
            </li>
            @else
                @can($objMen->permiso)
                <li class="menu-item" >
                    <a href="/{{$objMen->ruta}}" class="menu-link">
                        <i class="menu-icon text-dark {{$objMen->icono}}"></i>
                        <span class="menu-text">{{$objMen->titulo}}</span>
                    </a>
                </li>
                @endcan
            @endif
        @empty
        @endforelse
        </ul>

        <!--end::Menu Nav-->
    </div>
    <!--end::Menu Container-->
</div>
<!--end::Aside Menu-->
