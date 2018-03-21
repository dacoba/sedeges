<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sedeges</title>
    <link rel="icon" href="{{URL::asset('img/icon.ico')}}"/>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/full-slider.css') }}" rel="stylesheet">

</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Sedeges</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="{{ route('login') }}">Iniciar Sesion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="{{ route('register') }}">Registrar</a>
                        </li>
                    @else
                        @if (Auth::user()->rol == 'Administrador')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUsuarios" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Usuarios
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownUsuarios">
                                    <a class="dropdown-item" href="{{ url('usuario') }}">Mostrar Usuarios</a>
                                    <a class="dropdown-item" href="{{ url('usuario/create') }}">Registrar Usuarios</a>
                                </div>
                            </li>
                        @endif
                        @if (in_array(Auth::user()->rol, array('Administrador', 'Trabajador Social')))
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCentros" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Centros
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownCentros">
                                    <a class="dropdown-item" href="{{ url('centro') }}">Mostrar Centros</a>
                                    <a class="dropdown-item" href="{{ url('centro/create') }}">Registrar Centros</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownInfantes" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Infantes
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownInfantes">
                                    <a class="dropdown-item" href="{{ url('infante') }}">Mostrar Infantes</a>
                                    <a class="dropdown-item" href="{{ url('infante/create') }}">Registrar Infantes</a>
                                </div>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAdoptantes" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Adoptantes
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownAdoptantes">
                                <a class="dropdown-item" href="{{ url('adoptante') }}">Mostrar Adoptantes</a>
                                <a class="dropdown-item" href="{{ url('adoptante/create') }}">Registrar Adoptantes</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownSolicitudes" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Solicitudes de Adopcion
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownSolicitudes">
                                <a class="dropdown-item" href="{{ url('solicitud') }}">Mostrar Solicitudes de Adopcion</a>
                                <a class="dropdown-item" href="{{ url('solicitud/create') }}">Registrar Solicitudes de Adopcion</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownLogout" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->nombres }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownLogout">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    Cerrar Sesion
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
    </div>
</nav>

@yield('content')

<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Proyecto Sedeges 2018</p>
    </div>
</footer>

<!-- Bootstrap core JavaScript -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>
