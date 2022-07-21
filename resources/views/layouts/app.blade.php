<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- favIcon --}}
        <link rel="icon" type="image/x-icon" href="{{ asset('/img/favicon/favicon.ico')}}" />

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
            rel="stylesheet" />

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('/css/demo.css')}}" />
        <link rel="stylesheet" href="{{ asset('/css/core.css')}}" class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{ asset('/css/theme-default.css')}}" class="template-customizer-theme-css" />

        <!-- estilos para los iconos -->
        <link rel="stylesheet" href="{{ asset('/fonts/boxicons.css')}}" />

        <!-- Scripts -->
        <script src="{{ asset('/js/helpers.js')}}"></script>
        <script src="{{ asset('/js/config.js')}}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        @yield('cdns')

    </head>

    <body>
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                @include('layouts.asideNav')
                <div class="layout-page">
                    @include('layouts.navTop')
                    <div class="content-wrapper">
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <main>
                                @yield('content')
                            </main>
                        </div>
                    </div>
                    @include('layouts.footer')
                </div>
            </div>
        </div>
    </body>


<script src="{{ asset('/js/menu.js')}}"></script>
<script src="{{ asset('/js/main.js')}}"></script>
<script src="{{ asset('/js/dashboards-analytics.js')}}"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="{{ asset('https://buttons.github.io/buttons.js')}}"></script>



{{-- <script src="{{ asset('\plugins\jquery-3.5.1.min.js')}}"></script> --}}
<script src="{{ asset('plugins/datatables.net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('plugins/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('plugins/toast/jquery.toast.min.js') }}"></script>
<script src="{{ asset('plugins/jconfirm/jquery-confirm.min.js') }}"></script>
<link href="{{asset('plugins/jconfirm/jquery-confirm.min.css')}}" rel="stylesheet">
<script src="{{ asset('plugins/loadingoverlay.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('https://cdn.datatables.net/v/bs5/dt-1.11.4/datatables.min.js')}}"></script> 

<script src="{{ asset('plugins/appEngine.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $appEngine.setHost("{{ url('/') }}");
</script>

<script src="{{ asset('/js/bootstrap.js')}}"></script>
                    
<!-- Page JS -->
<script src="{{ asset('/js/pages-account-settings-account.js')}}"></script>

<script src="{{ asset('/controllers/Pedidos.js')}}"></script>
 
 
@yield('scripts')

</html>
