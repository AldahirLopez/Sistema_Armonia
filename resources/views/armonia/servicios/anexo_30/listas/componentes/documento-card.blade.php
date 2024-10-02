<div class="col-lg-6 mb-4">
    <div class="card border-0 shadow-sm">
        <div class="card-body d-flex align-items-center justify-content-between py-4">
            <!-- Icono a la izquierda -->
            <div class="icon-wrapper">
                @if($title == 'Programas informaticos')
                <i class="bx bx-folder-open bx-lg icon-color"></i>
                @elseif($title == 'Sistemas de medicion')
                <i class="bx bx-laptop bx-lg icon-color"></i>
                @elseif($title == 'Documentación de Medición')
                <i class="bx bx-ruler bx-lg icon-color"></i>
                @elseif($title == 'Documentación Inspección')
                <i class="bx bx-search-alt bx-lg icon-color"></i>
                @else
                <i class="bx bx-file bx-lg icon-color"></i>
                @endif
            </div>

            <!-- Descripción en el centro -->
            <div class="text-center flex-grow-1 px-3">
                <h5 class="card-title font-weight-bold">{{ $title }}</h5>
                <p class="card-text text-muted">Accede a la {{ strtolower($title) }} del servicio.</p>
            </div>

            <!-- Botón a la derecha -->
            <form action="{{ $action }}" method="GET">
                <input type="hidden" name="id" value="{{ $servicio->id }}">
                <button type="submit" class="btn btn-secondary">
                    <i class="bx bx-right-arrow-circle"></i>
                </button>
            </form>
        </div>
    </div>
</div>