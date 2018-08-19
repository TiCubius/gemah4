@extends('web._includes._master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Administration</h4>
                    <div>
                        <a href="{{ route("web.index") }}">
                            <button class="btn btn-outline-primary">Retour</button>
                        </a>
                    </div>
                </div>
                <hr class="w-100">
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="list-group mb-3">
                <div class="list-group-item flex-column align-items-start gemah-bg-color">
                    Académies et Régions
                </div>

                <a href="{{ route("web.administrations.academies.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
                    Gestion des Académies
                </a>
                <a href="{{ route("web.administrations.regions.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
                    Gestion des Régions
                </a>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="list-group mb-3">
                <div class="list-group-item flex-column align-items-start gemah-bg-color">
                    Services et Utilisateurs
                </div>

                <a href="{{ route("web.administrations.services.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
                    Gestion des Services
                </a>
                <a href="{{ route("web.administrations.utilisateurs.index") }}" class="list-group-item list-group-item-action flex-column align-items-start">
                    Gestion des Utilisateurs
                </a>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="list-group mb-3">
                <div class="list-group-item flex-column align-items-start gemah-bg-color">
                    Outils
                </div>

                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                    Gestion des Tickets
                </a>
                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                    Historique des Actions
                </a>
                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                    Liste des Permissions
                </a>
            </div>
        </div>

    </div>
@endsection
