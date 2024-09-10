@extends('layouts.master')

@section('title')
@lang('Anexo 30')
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') Selección @endslot
@slot('title') Anexo 30 @endslot
@endcomponent

<div class="row">
    <!-- Tarjeta: Servicios -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title" style="margin-block-start: 20px;">Servicios</h5>
                <div class="d-flex justify-content-between">
                    <div class="text-primary">
                        <h2><i class="bx bx-gear"></i></h2>
                    </div>
                    <div class="d-flex flex-column align-items-center">
                        <h4><span></span></h4>
                        <p class="mb-0">
                            <a href="{{ route('anexo.index') }}" class="text-primary">Ver más...</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection