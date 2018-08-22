@extends('web._includes._master')
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Gestion des Responsables</h4>
                    <div>
                        <a href="{{ route("web.responsables.create") }}">
                            <button class="btn btn-outline-primary">Nouveau Responsable</button>
                        </a>
                        <a href="{{ route("web.index") }}">
                            <button class="btn btn-outline-primary">Retour</button>
                        </a>
                    </div>
                </div>
                <hr class="w-100">
            </div>
        </div>

        @if ($latestCreatedResponsables->isEmpty())
            <div class="col-12 mb-3">
                <div class="alert alert-warning">
                    Aucun responsable n'est enregistré sur l'application
                </div>
            </div>
        @else
            <div class="col-12 mb-3">
                <form class="card" method="GET">
                    <div class="card-header gemah-bg-primary">Rechercher un responsable</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="optional" for="nom">Nom du responsable</label>
                            <input id="nom" class="form-control" name="nom" type="text" placeholder="Nom" value="{{ app("request")->input("nom") }}">
                        </div>

                        <div class="form-group">
                            <label class="optional" for="prenom">Prénom du responsable</label>
                            <input id="prenom" class="form-control" name="prenom" type="text" placeholder="Prénom" value="{{ app("request")->input("prenom") }}">
                        </div>

                        <div class="form-group">
                            <label class="optional" for="email">Adresse E-Mail</label>
                            <input id="email" class="form-control" name="email" type="text" placeholder="E-Mail" value="{{ app("request")->input("email") }}">
                        </div>

                        <div class="form-group">
                            <label class="optional" for="telephone">N° de Téléphone</label>
                            <input id="telephone" class="form-control" name="telephone" type="text" placeholder="Téléphonne" value="{{ app("request")->input("telephone") }}">
                        </div>

                        <div class="d-flex justify-content-end">
                            <button class="btn btn-outline-dark">Rechercher</button>
                        </div>
                    </div>

                    {{--<div class="card-footer d-flex justify-content-center">--}}
                    {{--<a href="{{ route("web.responsables.create") }}">--}}
                    {{--<button type="button" class="btn btn-success">Ajouter un nouveau responsable</button>--}}
                    {{--</a>--}}
                    {{--</div>--}}
                </form>
            </div>

            @isset($searchedResponsables)
                <div class="col-12 mb-3">
                    @if($searchedResponsables->isEmpty())
                        <div class="alert alert-warning">
                            Aucun responsable n'a été trouvé avec ces critères
                        </div>
                    @else
                        <table class="table table-sm table-hover text-center">
                            <thead class="gemah-bg-primary">
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($searchedResponsables as $Responsable)
                                    <tr>
                                        <th>{{ "{$Responsable->nom} {$Responsable->prenom}" }}</th>
                                        <td>{{ $Responsable->email }}</td>
                                        <td>{{ $Responsable->telephone }}</td>
                                        <td>
                                            <a href="#">
                                                <button class="btn btn-sm btn-outline-primary">Editer</button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            @else
                @if($latestCreatedResponsables->isNotEmpty())
                    <div class="col-12 mb-3">
                        <div class="card">
                            <div class="card-header bg-dark text-white">Derniers ajoutés</div>
                            <ul class="list-group list-group-flush">
                                @foreach($latestCreatedResponsables as $Responsable)
                                    <li class="list-group-item">{{ "{$Responsable->nom} {$Responsable->prenom}" }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @if($latestUpdatedResponsables->isNotEmpty())
                    <div class="col-12 mb-3">
                        <div class="card">
                            <div class="card-header bg-dark text-white">Derniers modifiés</div>
                            <ul class="list-group list-group-flush">
                                @foreach($latestUpdatedResponsables as $Responsable)
                                    <li class="list-group-item">{{ "{$Responsable->nom} {$Responsable->prenom}" }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            @endif
        @endif

    </div>
@endsection
