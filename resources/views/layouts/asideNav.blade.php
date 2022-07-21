<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{url('/dashboard')}}" class="app-brand-link">
            <span class="app-brand-text menu-text fw-bolder ms-2">Megci Productos</span>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <li class="menu-item active">
            <a href="{{url('/dashboard')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div>Inicio</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{url('/perfil')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user"></i>
                <div>Perfil</div>
            </a>
        </li>
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Paginas</span>
        </li>
        <li class="menu-item">
            <a href="{{url('/monedero')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div>Monedero Electronico</div>
            </a>
        </li>
        <!-- <li class="menu-item">
                <a href="historial.html" class="menu-link ">
                    <i class="menu-icon tf-icons bx bx-edit"></i>
                    <div>Historial</div>
                </a>
            </li>-->
        {{-- <li class="menu-item">
                <a href="/cupones" class="menu-link ">
                    <i class="menu-icon tf-icons bx bx-credit-card"></i>
                    <div>Cupones</div>
                </a>
            </li> --}}
        <li class="menu-item">
            <a href="{{url('/pedidos')}}" class="menu-link ">
                <i class="menu-icon tf-icons bx bx-notepad"></i>
                <div>Pedidos</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{url('/red')}}" class="menu-link ">
                <i class="menu-icon tf-icons bx bx-face"></i>
                <div>Red</div>
            </a>
        </li>
        <li class="menu-item">
            <form method="POST" action="{{ url('/logout')}}">
                @csrf
                <a class="dropdown-item" href="{{url('/logout')}}"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="bx bx-power-off me-2"></i>
                    <span>Salir</span>
                </a>
            </form>
        </li>
    </ul>
</aside>
