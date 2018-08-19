@extends('web._includes._master')
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Édition de {{ $Utilisateur->nom }}</h4>
                    <a href="{{ route("web.administrations.utilisateurs.index") }}">
                        <button class="btn btn-outline-primary">Retour</button>
                    </a>
                </div>
                <hr class="w-100">
            </div>
        </div>

        <div class="col-12">

            <form class="mb-3" action="{{ route("web.administrations.utilisateurs.update", [$Utilisateur->id]) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field("put") }}

                <div class="form-group row">
                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                        <label for="nom">Nom de l'utilisateur</label>
                        <input id="nom" class="form-control" name="nom" type="text" placeholder="Nom" value="{{ $Utilisateur->nom }}">
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="prenom">Prénom de l'utilisateur</label>
                        <input id="prenom" class="form-control" name="prenom" type="text" placeholder="Prénom" value="{{ $Utilisateur->prenom }}">
                    </div>
                </div>


                <div class="form-group">
                    <label for="email">Adresse E-Mail de l'utilisateur</label>
                    <input id="email" class="form-control" name="email" type="email" placeholder="Adresse E-Mail" value="{{ $Utilisateur->email }}">
                </div>


                <div class="form-group row">
                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                        <label for="academie">Académie de l'utilisateur</label>
                        <select id="academie" class="form-control" name="academie">
                            <option hidden>Sélectionner une Académie</option>
                            @foreach($Academies as $Academie)
                                @if($Utilisateur->academie_id === $Academie->id)
                                    <option selected value="{{ $Academie->id }}">{{ $Academie->nom }}</option>
                                @else
                                    <option value="{{ $Academie->id }}">{{ $Academie->nom }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                        <label for="service">Service de l'utilisateur</label>
                        <select id="service" class="form-control" name="service">
                            <option hidden>Sélectionner un Service</option>
                            @foreach($Services as $Service)
                                @if($Utilisateur->service_id === $Service->id)
                                    <option selected value="{{ $Service->id }}">{{ $Service->nom }}</option>
                                @else
                                    <option value="{{ $Service->id }}">{{ $Service->nom }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="d-flex justify-content-center">
                    <button class="btn btn-sm btn-outline-success">Éditer l'utilisateur</button>
                </div>
            </form>

        </div>
    </div>
@endsection
