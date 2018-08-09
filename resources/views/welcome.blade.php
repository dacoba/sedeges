@extends('layouts.appindex')

@section('content')
    <header>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <!-- Slide One - Set the background image for this slide in the line below -->
                <div class="carousel-item active" style="background-image: url('img/slider1.jpg');background-position: center">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>Sedeges</h3>
                        <p>Servicio Departamental de Gestion Social</p>
                    </div>
                </div>
                <!-- Slide Two - Set the background image for this slide in the line below -->
                <div class="carousel-item" style="background-image: url('img/slider2.jpg')">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>Adopta.</h3>
                        <p>Ten un Hij@ de Corazón.</p>
                    </div>
                </div>
                <!-- Slide Three - Set the background image for this slide in the line below -->
                <div class="carousel-item" style="background-image: url('img/slider4.jpg')">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>Campaña</h3>
                        <p>Por mi derecho a tener una familia.</p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </header>

    <!-- Page Content -->
    <section class="py-5">
        <div class="container">
            <h1>Sedeges</h1>
            <p>EL SEDEGES, tiene como misión fundamental aplicar normas y políticas sociales referidas al niños, niñas, adolecentes y grupo familiar a través de programas de prevención, protección y atención integral con las competencias de género, generacional y servicios sociales mediante el apoyo técnico a las instancias responsables y la supervisión del cumplimiento de los objetivos y resultados propuestos, así como la de coordinar los programas y proyectos en materia de gestión social. Al amparo de las disposiciones legales, el SEDEGES realiza trabajos en capacitación ocupacional en los diferentes espacios donde brinda el servicio, constituyéndose como una actividad que reporta resultados positivos en la autoestima personal y capacitación simultanea para enfrentar la vida, desde el punto de vista socio económico cuando las circunstancias a si lo permitan.</p>
        </div>
    </section>
@endsection
