@extends('layouts.app')
@section('cdns')
    <title>Inicio</title> 
    
    <!--estilos del nav-->
    <link rel="stylesheet" href="{{ asset('/css/theme-default.css')}}" class="template-customizer-theme-css" />
    <head>
        <meta charset="utf-8" />
        <meta
          name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
        />
        <title>Inicio</title>
        <meta name="description" content="" />
    
        <!-- Favicon -->
        {{-- <link rel="icon" type="image/x-icon" href="{{ asset('/img/favicon/favicon.ico')}}" /> --}}
    
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
          href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
          rel="stylesheet"
        />
    
        <!-- estilos para los iconos -->
        <link rel="stylesheet" href="{{ asset('/fonts/boxicons.css')}}" />
    
        <!-- estilos de la pagina -->
        <link rel="stylesheet" href="{{ asset('/css/core.css')}}" class="template-customizer-core-css" />
        
        <!--estilos del nav-->
        <link rel="stylesheet" href="{{ asset('/css/theme-default.css')}}" class="template-customizer-theme-css" />
    
        <link rel="stylesheet" href="{{ asset('/css/demo.css')}}" />
    
        <script src="{{ asset('/js/helpers.js')}}"></script> 
      </head>
     
@endsection

@section('content')
    {{-- Page content --}}
    
         

        <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="row">
                    <div class="col-lg-8 mb-4 order-0">
                        <div class="card">
                            <div class="d-flex align-items-end row">
                                <div class="col-sm-7">
                                    <div class="card-body">
                                        <h5 class="card-title">Bienvenido {{ Auth::user()->name }}!</h5>
                                    </div>
                                </div>
                                <div class="col-sm-5 text-center text-sm-left">
                                    <div class="card-body pb-0 px-0 px-md-4">
                                        <img src="{{ asset('/img/illustrations/man-with-laptop-light.png')}}" height="140"
                                            alt="View Badge User" data-app-dark-img="{{ asset('illustrations/man-with-laptop-dark.png')}}"
                                            data-app-light-img="{{ asset('illustrations/man-with-laptop-light.png')}}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 order-1">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title d-flex align-items-start justify-content-between">
                                            <div class="avatar flex-shrink-0">
                                                <img src="{{ asset('/img/icons/unicons/chart-success.png')}}" alt="chart success"
                                                    class="rounded" />
                                            </div>
                                        </div>
                                        <span class="fw-semibold d-block mb-1">Saldo En Puntos</span>
                                        <h3 class="card-title mb-2">1728</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title d-flex align-items-start justify-content-between">
                                            <div class="avatar flex-shrink-0">
                                                <img src="{{ asset('/img/icons/unicons/wallet-info.png')}}" alt="Credit Card"
                                                    class="rounded" />
                                            </div>
                                        </div>
                                        <span>Saldo Dinero</span>
                                        <h3 class="card-title text-nowrap mb-1">$40.00</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Total Revenue -->
                    <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                        <div class="card">
                            <div class="row row-bordered g-0">
                                <div class="text-center col-md-8">
                                    <h5 class="text-center card-header m-0 me-2 pb-3">Envianos un mensaje y en
                                        un momento te atenderemos.</h5>

                                    <div class="text-center fw-semibold pt-3 mb-2">
                                        <a href="https://api.whatsapp.com/send?phone=+522223146078&text=Hola sean bienvenidos!!"
                                            class=" text-center btn btn-outline-success d-grid gap-2" target="_blanck"
                                            type="button">
                                            <i class='bx bxl-whatsapp'></i>
                                        </a>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <div class="dropdown">
                                                <button type="button" class="btn rounded-pill btn-success"
                                                    data-bs-toggle="modal" data-bs-target="#modalCenter">
                                                    Calendario <i class='bx bx-notepad'></i>
                                                </button>
                                                <div class="modal fade" id="modalCenter" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalCenterTitle">
                                                                    Calendario</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row g-2">
                                                                    <div class="row g-2">
                                                                        <div class="col mb-0">
                                                                            <label for="emailWithTitle"
                                                                                class="form-label"><i
                                                                                    class='bx bx-search-alt'></i>Buscar</label>
                                                                            <input type="text" id="emailWithTitle"
                                                                                class="form-control"
                                                                                placeholder="Pastillas,Cremas etc.." />
                                                                        </div>
                                                                        <div class="col mb-0">
                                                                            <input type="month" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="row g-3">

                                                                        <button type="button"
                                                                            class="btn rounded-pill btn-outline-success">
                                                                            <i class='bx bx-search-alt'></i>Buscar
                                                                            Productos
                                                                        </button>
                                                                        <div class="col mb-0">
                                                                            <label for="dobWithTitle"
                                                                                class="form-label">Comisiones
                                                                                De Mes:</label>
                                                                        </div>
                                                                        <div class="col mb-0">
                                                                            <input type="text" id="dobWithTitle"
                                                                                class="form-control"
                                                                                placeholder="$ 12.00" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Total Revenue -->
                    <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
                        <div class="row">
                            <div class="col-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title d-flex align-items-start justify-content-between">
                                            <div class="avatar flex-shrink-0">
                                                <img src="{{ asset('/img/icons/unicons/cc-primary.png')}}" alt="Credit Card"
                                                    class="rounded" />
                                            </div>
                                        </div>
                                        <span class="fw-semibold d-block mb-1">Puntos Acomulados</span>
                                        <h3 class="card-title mb-2">140</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title d-flex align-items-start justify-content-between">
                                            <div class="avatar flex-shrink-0">
                                                <img src="{{ asset('/img/icons/unicons/paypal.png')}}" alt="Credit Card"
                                                    class="rounded" />
                                            </div>
                                        </div>
                                        <span class="fw-semibold d-block mb-1">Comisiones Por Mes </span>
                                        <h3 class="card-title mb-2">$140.00</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 

        </div>
    
 @endsection
