@extends('web._includes._master')
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Liste des Utilisateurs</h4>
                    <a href="{{ route("web.administrations.utilisateurs.create") }}">
                        <button class="btn btn-outline-primary">Nouvel Utilisateur</button>
                    </a>
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
                    <tr>
                        <th>TARTIERE Kevin</th>
                        <td>Développeur</td>
                        <td>ktartiere@gmail.com</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">Editer</button>
                        </td>
                    </tr>
                    <tr>
                        <th>MOULIN Théo</th>
                        <td>Développeur</td>
                        <td></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">Editer</button>
                        </td>
                    </tr>
                    <tr>
                        <th>ARNAUD Louis</th>
                        <td>Développeur</td>
                        <td></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary">Editer</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
