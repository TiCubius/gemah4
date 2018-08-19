@extends('web._includes._master')
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Liste des Régions</h4>
                    <div>
                        <a href="{{ route("web.administrations.regions.create") }}">
                            <button class="btn btn-outline-primary">Nouvelle Région</button>
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Regions as $Region)
                        <tr>
                            <td>{{ $Region->nom }}</td>
                            <td>
                                <a href="{{ route("web.administrations.regions.edit", [$Region->id]) }}">
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