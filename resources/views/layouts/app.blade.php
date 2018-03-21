<?php error_reporting(0);?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sedeges') }}</title>
    <link rel="icon" href="{{URL::asset('img/icon.ico')}}"/>

    <!-- Styles -->
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/modern-business.css') }}" rel="stylesheet">
    <link href="{{ asset('typehead/examples.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand js-scroll-trigger" href="{{ url('/') }}">Sedeges</a>
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
    </div>
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Proyecto Sedeges 2018</p>
        </div>
        <!-- /.container -->
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('typehead/handlebars.js') }}"></script>
    <script src="{{ asset('typehead/jquery-1.10.2.min.js') }}"></script>
    <script src="{{ asset('typehead/dist/typeahead.bundle.js') }}"></script>
    <script>
        var url = "{{ route('adoptantes.json') }}";
        var dataSets = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('ci'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: {
                url: url,
                cache: false
            }
        });

        $('#adoptante_search').typeahead('destroy').typeahead(null, {
            name: name,
            source: dataSets,
            display: function(data) { return data.ci + " " + data.ci_extencion + " - " + data.nombres + " " + data.apellido_paterno + " " + data.apellido_materno; },
            templates: {
                empty: [
                    '<div class="empty-message">',
                    'No se encontraron resultados para su busqueda',
                    '</div>'
                ].join('\n'),
                suggestion: Handlebars.compile('<div>{{ "{"."{ci}"."}" }} {{ "{"."{ci_extencion}"."}" }} – {{ "{"."{nombres}"."}" }} {{ "{"."{apellido_paterno}"."}" }} {{ "{"."{apellido_materno}"."}" }}</div>')
            }
        });
        $('#adoptante_search').on('typeahead:selected', function (e, datum) {
            document.getElementById('adoptante_user_id').value = datum['id'];
        });
    </script>
{{--    <script src="{{ asset('js/jquery.min.js') }}"></script>--}}
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#dataTable').dataTable( {
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            } );
        } );
    </script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('js/sb-admin.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-datatables.min.js') }}"></script>
    <script>
        $("input[type=file]").change(function (event) {
            var fieldVal = event.target.files[0].name;
            if (fieldVal != undefined || fieldVal != "") {
                $(this).next(".custom-file-label").text(fieldVal);
            }
        });
    </script>
</body>
</html>
