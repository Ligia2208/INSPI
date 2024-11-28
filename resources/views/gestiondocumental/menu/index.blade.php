<div class="col-xl-3">
    
    <ul class="navi navi-link-rounded navi-accent navi-hover navi-active nav flex-column mb-8 mb-lg-0" role="tablist">

        <li class="navi-item mb-2">
            <a class="navi-link {{ active('setting.welcome.index') }}" href="{{ route('gestiondocumental.reporte.index') }}">
                <span class="navi-text text-dark-50 font-size-h5 font-weight-bold">
                    <i class="fab fa-buffer text-dark mr-2"></i> Bienvenido
                </span>
            </a>
        </li>

        <li class="navi-item mb-2">
            <a class="navi-link {{ active('setting.role.*') }}" href="{{ route('gestiondocumental.seguimiento.index') }}">
                <span class="navi-text text-dark-50 font-size-h5 font-weight-bold">
                    <i class="fa fa-cog text-dark mr-2"></i> Diario (Hoy)
                </span>
            </a>
        </li>

        <li class="navi-item mb-2">
            <a class="navi-link {{ active('setting.permission.*') }}"  href="{{ route('setting.permission.index') }}">
                <span class="navi-text text-dark-50 font-size-h5 font-weight-bold">
                    <i class="fa fa-cog text-dark mr-2"></i> Últimos 7 dias
                </span>
            </a>
        </li>

        <li class="navi-item mb-2">
            <a class="navi-link {{ active('setting.account.*') }}" href="{{ route('setting.account.index') }}">
                <span class="navi-text text-dark-50 font-size-h5 font-weight-bold">
                    <i class="fa fa-cog text-dark mr-2"></i> Último 30 días
                </span>
            </a>
        </li>

        <li class="navi-item mb-2">
            <a class="navi-link {{ active('setting.payment-type.*') }}" href="{{ route('setting.payment-type.index') }}">
                <span class="navi-text text-dark-50 font-size-h5 font-weight-bold">
                    <i class="fa fa-cog text-dark mr-2"></i> Acumulado
                </span>
            </a>
        </li>

        <li class="navi-item mb-2">
            <a class="navi-link {{ active('setting.category-client.*') }}" href="{{ route('setting.category-client.index') }}">
                <span class="navi-text text-dark-50 font-size-h5 font-weight-bold">
                    <i class="fa fa-cog text-dark mr-2"></i> Por tiempo de respuesta 
                </span>
            </a>
        </li>
        
    </ul>
   
</div>