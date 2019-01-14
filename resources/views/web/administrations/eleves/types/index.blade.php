@extends('web._includes._master')
@section('content')
    <div class="row">

        @component("web._includes.components.title", ["add" => "web.administrations.eleves.types.create", "back" => "web.administrations.index"])
            Gestion des types d'élèves
        @endcomponent

        <div class="col-12">
            @if($typeEleves->isEmpty())
                <div class="alert alert-warning">
                    Aucun type d'élève n'est enregistré sur l'application
                </div>
            @else
                <table class="table table-sm table-hover text-center">
                    <thead class="gemah-bg-primary">
                    <tr>
                        <th>Nom</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($typeEleves as $typeEleve)
                        <tr>
                            <td>{{ $typeEleve->nom }}</td>
                            <td>
                                <a href="{{ route("web.administrations.eleves.types.edit", [$typeEleve]) }}">
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
