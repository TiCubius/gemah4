@extends('web._includes._master')
@section('content')
    @component("web._includes.components.title", ["add" => "web.scolarites.eleves.affectations.materiels.index", "back" => "web.scolarites.eleves.show", "id" => [$eleve]])
        Gestion du matériel
    @endcomponent

    <div class="row">
        <div class="col-md-12 mt-3">
            @if(count($eleve->materiels) == 0)
                <div class="w-100 disabled">
                    <div class="alert alert-warning text-center">
                        Aucun matériel n'est attribué à {{ $eleve->prenom }} {{ $eleve->nom }}
                    </div>
                </div>
            @else
                <div class="card">
                    <table class="table table-hover mb-0">
                        <thead class="table-striped card-header gemah-bg-primary">
                        <tr>
                            <th scope="col"> Type</th>
                            <th scope="col"> Marque</th>
                            <th scope="col"> Modèle</th>
                            <th scope="col"> Date du prêt</th>
                            <th scope="col"> Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($eleve->materiels as $materiel)
                            <tr>
                                <td>{{ $materiel->type->nom }}</td>
                                <td>{{ $materiel->marque }}</td>
                                <td>{{ $materiel->modele }}</td>
                                <td>{{ \Carbon\Carbon::parse($materiel->updated_at)->format('d/m/Y') }}</td>
                                <td class="d-flex">
                                    <a href="{{ route('web.materiels.stocks.show', [$materiel]) }}" target="_blank"
                                       class="btn btn-sm btn-outline-primary mr-3">
                                        Détail
                                    </a>
                                    <form action="{{ route('web.scolarites.eleves.affectations.materiels.detach', [$eleve, $materiel]) }}"
                                          method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field("DELETE") }}
                                        <button class="btn btn-sm btn-outline-danger">Désaffecter</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection

@include("web._includes.sidebars.eleve")