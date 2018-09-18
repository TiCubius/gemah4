@extends('web._includes._master')
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Création d'un Responsable</h4>
                    <a href="{{ route("web.responsables.index") }}">
                        <button class="btn btn-outline-primary">Retour</button>
                    </a>
                </div>
                <hr class="w-100">
            </div>
        </div>

        <div class="col-12">
            <form class="mb-3" action="{{ route("web.responsables.index") }}" method="POST">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="civilite">Civilité</label>
                    <select id="civilite" class="form-control" name="civilite" required>
                        <option hidden value="">Veuillez sélectionner la civilité</option>
                        <option value="M">M</option>
                        <option value="Mme">Mme</option>
                        <option value="M / Mme">M / Mme</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nom">Nom du responsable</label>
                    <input id="nom" class="form-control" name="nom" type="text" placeholder="Ex: Smith" value="{{ old("nom") }}" required>
                </div>

                <div class="form-group">
                    <label for="prenom">Prénom du responsable</label>
                    <input id="prenom" class="form-control" name="prenom" type="text" placeholder="Ex: John" value="{{ old("prenom") }}" required>
                </div>


                <div class="form-group">
                    <label class="optional" for="email">Adresse E-Mail du responsable</label>
                    <input id="email" class="form-control" name="email" type="email" placeholder="Ex: john.smith@exemple.fr" value="{{ old("email") }}">
                </div>

                <div class="form-group">
                    <label class="optional" for="telephone">Téléphone du responsable</label>
                    <input id="telephone" class="form-control" name="telephone" type="text" placeholder="Ex: 04 77 81 41 00" value="{{ old("telephone") }}">
                </div>


                <div class="form-group">
                    <label class="optional" for="code_postal">Code postal du responsable</label>
                    <input id="code_postal" class="form-control" name="code_postal" type="text" placeholder="Ex: 42100" value="{{ old("code_postal") }}">
                </div>

                <div class="form-group">
                    <label class="optional" for="ville">Ville du responsable</label>
                    <input id="ville" class="form-control" name="ville" type="text" placeholder="Ex: Saint-Etienne" value="{{ old("ville") }}">
                </div>

                <div class="form-group">
                    <label class="optional" for="adresse">Adresse du responsable</label>
                    <input id="adresse" class="form-control" name="adresse" type="text" placeholder="Ex: 11 Rue des Docteurs Charcot" value="{{ old("adresse") }}">
                </div>


                <div class="d-flex justify-content-center">
                    <button class="btn btn-sm btn-outline-success">Créer le responsable</button>
                </div>
            </form>
        </div>

    </div>
@endsection
