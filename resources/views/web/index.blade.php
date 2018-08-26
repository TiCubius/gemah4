@extends('web._includes._master')
@section('content')
    <div class="row">

        <div class="col-12">
            <a href="#">
                <button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
                    Gestion des Elèves
                </button>
            </a>
        </div>

        <div class="col-12">
            <a href="{{ route("web.responsables.index") }}">
                <button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
                    Gestion des Responsables
                </button>
            </a>
        </div>

        <div class="col-12">
            <a href="{{ route("web.materiels.index") }}">
                <button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
                    Gestion du Matériel
                </button>
            </a>
        </div>

        <div class="col-12">
            <a href="#">
                <button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
                    Statistiques
                </button>
            </a>
        </div>

        <div class="col-12">
            <a href="{{ route('web.administrations.index') }}">
                <button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
                    Administrations
                </button>
            </a>
        </div>

    </div>
@endsection
