<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $title }}</h5>
        <ol class="list-group list-group-numbered">
            <li class="list-group-item">DICTAMEN TÉCNICO DE {{ strtoupper($type === 'informatico' ? 'PROGRAMAS INFORMÁTICOS' : 'MEDICIÓN') }}</li>
        </ol>
        <a href="#" class="btn btn-primary mt-2" data-toggle="modal" data-target="#dictamenesModal{{ $type }}">Generar</a>
    </div>
</div>
