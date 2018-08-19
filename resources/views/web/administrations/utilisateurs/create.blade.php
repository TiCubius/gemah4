@extends('web._includes._master')
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Création d'un nouvel utilisateur</h4>
                    <a href="{{ route("web.administrations.utilisateurs.index") }}">
                        <button class="btn btn-outline-primary">Retour</button>
                    </a>
                </div>
                <hr class="w-100">
            </div>
        </div>

        <div class="col-12">

            <form class="mb-3" action="{{ route("web.administrations.utilisateurs.index") }}" method="POST">
                {{ csrf_field() }}

                <div class="form-group row">
                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                        <label for="nom">Nom de l'utilisateur</label>
                        <input id="nom" class="form-control" name="nom" type="text" placeholder="Nom" value="{{ old("nom") }}">
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="prenom">Prénom de l'utilisateur</label>
                        <input id="prenom" class="form-control" name="prenom" type="text" placeholder="Prénom" value="{{ old("prenom") }}">
                    </div>
                </div>


                <div class="form-group">
                    <label for="email">Adresse E-Mail de l'utilisateur</label>
                    <input id="email" class="form-control" name="email" type="email" placeholder="Adresse E-Mail" value="{{ old("email") }}">
                </div>


                <div class="form-group row">
                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                        <label for="password">Mot de passe de l'utilisateur</label>
                        <input id="password" class="form-control" name="password" type="password" placeholder="Mot de passe">
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="password_confirmation">Confirmation du mot de passe de l'utilisateur</label>
                        <input id="password_confirmation" class="form-control" name="password_confirmation" type="password" placeholder="Confirmation du mot de passe">
                    </div>
                </div>


                <div class="form-group row">
                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                        <label for="academie">Académie de l'utilisateur</label>
                        <select id="academie" class="form-control" name="academie">
                            <option hidden>Sélectionner une Académie</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                        <label for="service">Service de l'utilisateur</label>
                        <select id="service" class="form-control" name="service">
                            <option hidden>Sélectionner un Service</option>
                        </select>
                    </div>
                </div>


                <div class="d-flex justify-content-center">
                    <button class="btn btn-sm btn-outline-success">Créer l'utilisateur</button>
                </div>
            </form>

        </div>
    </div>
@endsection
