@extends('web._includes._master')
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Création d'un Type Matériel</h4>
                    <a href="{{ route("web.materiels.types.index") }}">
                        <button class="btn btn-outline-primary">Retour</button>
                    </a>
                </div>
                <hr class="w-100">
            </div>
        </div>

        <div class="col-12">
            <form class="mb-3" action="{{ route("web.materiels.types.index") }}" method="POST">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="nom">Nom du type</label>
                    <input id="nom" class="form-control" name="nom" type="text" placeholder="Ex: Smith" value="{{ old("nom") }}" required>
                </div>

                <div class="form-group">
                    <label for="domaine">Domaine Matériel</label>
                    <select id="domaine" class="form-control" name="domaine" required>
                        <option value="" hidden>Sélectionner un Domaine</option>
                        @foreach($DomainesMateriel as $DomaineMateriel)
                            <option value="{{ $DomaineMateriel->id }}">{{ $DomaineMateriel->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-center">
                    <button class="btn btn-sm btn-outline-success">Créer le type</button>
                </div>
            </form>
        </div>

    </div>
@endsection
