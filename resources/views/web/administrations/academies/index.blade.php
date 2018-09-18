@extends('web._includes._master')
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Liste des Académies</h4>
                    <div>
                        <a href="{{ route("web.administrations.academies.create") }}">
                            <button class="btn btn-outline-primary">Ajouter</button>
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
            @if($Academies->isEmpty())
                <div class="alert alert-warning">
                    Aucune académie n'est enregistré sur l'application
                </div>
            @else
                <table class="table table-sm table-hover text-center">
                    <thead class="gemah-bg-primary">
                        <tr>
                            <th>Nom</th>
                            <th>Région</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($Academies as $Academie)
                            <tr>
                                <td>{{ $Academie->nom }}</td>
                                <td>{{ $Academie->region->nom }}</td>
                                <td>
                                    <a href="{{ route("web.administrations.academies.edit", [$Academie->id]) }}">
                                        <button class="btn btn-sm btn-outline-primary">Editer</button>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
