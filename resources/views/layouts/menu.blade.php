<!--begin::Aside Menu-->
<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
    <!--begin::Menu Container-->
    <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"
        data-menu-dropdown-timeout="500">
        <!--begin::Menu Nav-->
        <ul class="menu-nav">
            <li class="menu-section">
                <h4 class="menu-text">Bienvenida</h4>
                <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
            </li>

            <li class="menu-item {{ active('dashboard.index') }}">
                <a href="{{ route('dashboard.index') }}" class="menu-link">
                    <i class="menu-icon text-dark fab fa-buffer"></i>
                    <span class="menu-text">General</span>
                </a>
            </li>

            @canany(['areas', 'direcciones', 'cargos'])

                <div class="my-5"></div>

                <li class="menu-section">
                    <h4 class="menu-text">Catálogos</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>

                @can('areas')
                <li class="menu-item {{ active('area.*') }}">
                    <a href="{{ route('area.index') }}" class="menu-link">
                        <i class="menu-icon text-dark fa fa-cube"></i>
                        <span class="menu-text">Áreas</span>
                    </a>
                </li>
                @endcan

                @can('direcciones')
                    <li class="menu-item {{ active('direccion.*') }}">
                        <a href="{{ route('direccion.index') }}" class="menu-link">
                            <i class="menu-icon text-dark fa fa-cubes"></i>
                            <span class="menu-text">Direcciones</span>
                        </a>
                    </li>
                @endcan

                @can('direccionestec')
                    <li class="menu-item {{ active('direcciontec.*') }}">
                        <a href="{{ route('dirtecnica.index') }}" class="menu-link">
                            <i class="menu-icon text-dark fa fa-cogs"></i>
                            <span class="menu-text">Plataformas/CRN/Gestiones</span>
                        </a>
                    </li>
                @endcan

                @can('cargos')
                    <li class="menu-item {{ active('cargo.*') }}">
                        <a href="{{ route('cargo.index') }}" class="menu-link">
                            <i class="menu-icon text-dark fa fa-tasks"></i>
                            <span class="menu-text">Definición Cargos</span>
                        </a>
                    </li>
                @endcan
            @endcanany

            @canany(['ticketsupport', 'ticketuser'])

                <div class="my-5"></div>

                <li class="menu-section">
                    <h4 class="menu-text">Soporte TICs</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>

                @can('ticketsupport')
                <li class="menu-item {{ active('ticketsupport.*') }}">
                    <a href="{{ route('ticketsupport.index') }}" class="menu-link">
                        <i class="menu-icon text-dark fa fa-tags"></i>
                        <span class="menu-text">Gestión Tickets</span>
                    </a>
                </li>
                @endcan
                @can('ticketuser')
                <li class="menu-item {{ active('ticketuser.*') }}">
                    <a href="{{ route('ticketuser.index') }}" class="menu-link">
                        <i class="menu-icon text-dark fa fa-clone"></i>
                        <span class="menu-text">Tickets</span>
                    </a>
                </li>
                @endcan
                @can('tickettecnico')
                <li class="menu-item {{ active('tickettecnico.*') }}">
                    <a href="{{ route('tickettecnico.index') }}" class="menu-link">
                        <i class="menu-icon text-dark fa fa-cogs"></i>
                        <span class="menu-text">Tickets Asignados</span>
                    </a>
                </li>
                @endcan
            @endcanany

            @canany(['convenios'])
                <div class="my-5"></div>
                <li class="menu-section">
                    <h4 class="menu-text">Intranet</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>

                @can('convenios')
                    <li class="menu-item {{ active('convenio.*') }}">
                        <a href="{{ route('convenio.index') }}" class="menu-link">
                            <i class="menu-icon text-dark fa fa-object-group"></i>
                            <span class="menu-text">Convenios</span>
                        </a>
                    </li>
                @endcan

            @endcanany

            @canany(['pacientes','resultados','visorresultados','resultadosmsp','resultadoscrn','preanalitica','postanaliticas'])
                <div class="my-5"></div>
                <li class="menu-section">
                    <h4 class="menu-text">Resultados CRNs</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>
                @can('pacientes')
                    <li class="menu-item {{ active('paciente.*') }}">
                        <a href="{{ route('paciente.index') }}" class="menu-link">
                            <i class="menu-icon text-dark fa fa-users"></i>
                            <span class="menu-text">Pacientes</span>
                        </a>
                    </li>
                @endcan
                @can('preanalitica')
                    <li class="menu-item {{ active('preanalitica.*') }}">
                        <a href="{{ route('preanalitica.index') }}" class="menu-link">
                            <i class="menu-icon text-dark fa fa-cogs"></i>
                            <span class="menu-text">Muestras - Preanalítica</span>
                        </a>
                    </li>
                @endcan
                @can('resultados')
                    <li class="menu-item {{ active('resultado.*') }}">
                        <a href="{{ route('resultado.index') }}" class="menu-link">
                            <i class="menu-icon text-dark fa fa-object-group"></i>
                            <span class="menu-text">Registro Resultados</span>
                        </a>
                    </li>
                @endcan
                @can('resultadosmsp')
                    <li class="menu-item {{ active('resultadomsp.*') }}">
                        <a href="{{ route('resultadomsp.index') }}" class="menu-link">
                            <i class="menu-icon text-dark fa fa-desktop"></i>
                            <span class="menu-text">Resultados MSP</span>
                        </a>
                    </li>
                @endcan
                @can('resultadoscrn')
                    <li class="menu-item {{ active('resultadocrn.*') }}">
                        <a href="{{ route('resultadocrn.index') }}" class="menu-link">
                            <i class="menu-icon text-dark fa fa-object-group"></i>
                            <span class="menu-text">Registro Resultados CRN</span>
                        </a>
                    </li>
                @endcan
                @can('analiticas')
                    <li class="menu-item {{ active('analitica.*') }}">
                        <a href="{{ route('analitica.index') }}" class="menu-link">
                            <i class="menu-icon text-dark fa fa-spinner"></i>
                            <span class="menu-text">Analitica Resultados CRN</span>
                        </a>
                    </li>
                @endcan
                @can('postanaliticas')
                    <li class="menu-item {{ active('postanalitica.*') }}">
                        <a href="{{ route('postanalitica.index') }}" class="menu-link">
                            <i class="menu-icon text-dark fa fa-spinner"></i>
                            <span class="menu-text">Postanalitica Resultados CRN</span>
                        </a>
                    </li>
                @endcan
            @endcanany

            @canany(['articulos', 'actainventario', 'participantes'])
                <li class="menu-section">
                    <h4 class="menu-text">Inventario General</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>
                @can('participantes')
                    <li class="menu-item {{ active('participante.*') }}">
                        <a href="{{ route('participante.index') }}" class="menu-link">
                            <i class="menu-icon text-dark fa fa-address-book"></i>
                            <span class="menu-text">Participantes Acta Bienes</span>
                        </a>
                    </li>
                @endcan
                @can('articulos')
                    <li class="menu-item {{ active('articulo.*') }}">
                        <a href="{{ route('articulo.index') }}" class="menu-link">
                            <i class="menu-icon text-dark fa fa-qrcode"></i>
                            <span class="menu-text">Inventario Artículos</span>
                        </a>
                    </li>
                @endcan
                @can('actainventario')
                    <li class="menu-item {{ active('actausuario.*') }}">
                        <a href="{{ route('actausuario.index') }}" class="menu-link">
                            <i class="menu-icon text-dark fa fa-barcode"></i>
                            <span class="menu-text">Actas por Funcionarios</span>
                        </a>
                    </li>
                @endcan
            @endcanany

            @canany(['contrataciones', 'personas'])
                <li class="menu-section">
                    <h4 class="menu-text">Talento Humano</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>
                @can('personas')
                    <li class="menu-item {{ active('persona.*') }}">
                        <a href="{{ route('persona.index') }}" class="menu-link">
                            <i class="menu-icon text-dark fa fa-user-plus"></i>
                            <span class="menu-text">Registro Personas</span>
                        </a>
                    </li>
                @endcan
                @can('contrataciones')
                    <li class="menu-item {{ active('filiacion.*') }}">
                        <a href="{{ route('filiacion.index') }}" class="menu-link">
                            <i class="menu-icon text-dark fa fa-id-card"></i>
                            <span class="menu-text">Contrataciones</span>
                        </a>
                    </li>
                @endcan
            @endcanany

            @canany(['pladetalle', 'plaactividades', 'pladireccion'])
                <li class="menu-section">
                    <h4 class="menu-text">Admin Planificación</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>
                @can('pladetalle')
                    <li class="menu-item {{ active('persona.*') }}">
                        <a href="{{ route('planificacion.detalle') }}" class="menu-link">
                            <i class="menu-icon text-dark bi bi-list-task"></i>
                            <span class="menu-text">Detalle</span>
                        </a>
                    </li>
                @endcan

                @can('plaactividades')
                    <li class="menu-item {{ active('persona.*') }}">
                        <a href="{{ route('planificacion') }}" class="menu-link">
                            <i class="menu-icon text-dark bi bi-clipboard-check"></i>
                            <span class="menu-text">Lista de Actividades</span>
                        </a>
                    </li>
                @endcan

                @can('pladireccion')
                    <li class="menu-item {{ active('persona.*') }}">
                        <a href="{{ route('montoDireccion') }}" class="menu-link">
                            <i class="menu-icon text-dark bi bi-map"></i>
                            <span class="menu-text">Lista de Direcciones</span>
                        </a>
                    </li>
                @endcan

            @endcanany

            @canany(['plamontoitem', 'plaactividadesitems'])
                <li class="menu-section">
                    <h4 class="menu-text">Planificación</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>
                @can('plamontoitem')
                    <li class="menu-item {{ active('persona.*') }}">
                        <a href="{{ route('itemPresupuestario.monto_item') }}" class="menu-link">
                            <i class="menu-icon text-dark bi bi-plus-circle"></i>
                            <span class="menu-text">Agregar Items</span>
                        </a>
                    </li>
                @endcan

                @can('plaactividadesitems')
                    <li class="menu-item {{ active('persona.*') }}">
                        <a href="{{ route('planificacion.vistaUser') }}" class="menu-link">
                            <i class="menu-icon text-dark bi bi-person-lines-fill"></i>
                            <span class="menu-text">Lista de Actividades</span>
                        </a>
                    </li>
                @endcan

            @endcanany

            @canany(['usuarios', 'reportes', 'ajustes', 'log'])
                <div class="my-5"></div>
                <li class="menu-section">
                    <h4 class="menu-text">Ajustes</h4>
                    <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                </li>

                @can('usuarios')
                    <li class="menu-item {{ active('user.*') }}">
                        <a href="{{ route('user.index') }}" class="menu-link">
                            <i class="menu-icon text-dark fa fa-users"></i>
                            <span class="menu-text">Usuarios</span>
                        </a>
                    </li>
                @endcan
                @can('ajustes')
                    <li class="menu-item {{ active('setting.*') }}">
                        <a href="{{ route('setting.welcome.index') }}" class="menu-link">
                            <i class="menu-icon text-dark fa fa-cog"></i>
                            <span class="menu-text">Configuraciones</span>
                        </a>
                    </li>
                @endcan
                @can('log')
                    <li class="menu-item {{ active('log.*') }}">
                        <a href="{{ route('log.index') }}" class="menu-link">
                            <i class="menu-icon text-dark far fa-eye"></i>
                            <span class="menu-text">Logs</span>
                        </a>
                    </li>
                @endcan
            @endcanany
        </ul>
        <!--end::Menu Nav-->
    </div>
    <!--end::Menu Container-->
</div>
<!--end::Aside Menu-->
