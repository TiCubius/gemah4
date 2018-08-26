@extends('web._includes._master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Gestion du Matériel</h4>
                    <div>
                        <a href="{{ route("web.index") }}">
                            <button class="btn btn-outline-primary">Retour</button>
                        </a>
                    </div>
                </div>
                <hr class="w-100">
            </div>
        </div>

        <div class="col-12">
            <a href="{{ route("web.materiels.index") }}">
                <button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
                    Gestion des Stocks de Matériel
                </button>
            </a>
        </div>

        <div class="col-12">
            <a href="{{ route("web.materiels.domaines.index") }}">
                <button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
                    Gestion des Domaines Matériel
                </button>
            </a>
        </div>

        <div class="col-12">
            <a href="{{ route("web.materiels.types.index") }}">
                <button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
                    Gestion des Types Matériel
                </button>
            </a>
        </div>
    </div>
@endsection
