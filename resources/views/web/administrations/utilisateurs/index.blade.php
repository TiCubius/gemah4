@extends('web._includes._master')
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Liste des Utilisateurs</h4>
                    <div>
                        <a href="{{ route("web.administrations.utilisateurs.create") }}">
                            <button class="btn btn-outline-primary">Nouvel Utilisateur</button>
                        </a>
                        <a href="{{ route("web.administrations.index") }}">
                            <button class="btn btn-outline-primary">Retour</button>
                        </a>
                    </div>
                </div>
                <hr class="w-100">
            </div>
        </div>

        <div class="col-12">
            <table class="table table-sm table-hover text-center">
                <thead class="thead-dark">
                    <tr>
                        <th>Nom</th>
                        <th>Rôle</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Utilisateurs as $Utilisateur)
                        <tr>
                            <th>{{ "{$Utilisateur->nom} {$Utilisateur->prenom}" }}</th>
                            <td>{{ $Utilisateur->service->nom }}</td>
                            <td>{{ $Utilisateur->email }}</td>
                            <td>
                                <a href="{{ route("web.administrations.utilisateurs.edit", [$Utilisateur->id]) }}">
                                    <button class="btn btn-sm btn-outline-primary">Editer</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
