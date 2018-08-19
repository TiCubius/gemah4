@extends('web._includes._master')
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Création d'une Région</h4>
                    <a href="{{ route("web.administrations.academies.index") }}">
                        <button class="btn btn-outline-primary">Retour</button>
                    </a>
                </div>
                <hr class="w-100">
            </div>
        </div>

        <div class="col-12">

            <form class="mb-3" action="{{ route("web.administrations.regions.index") }}" method="POST">
                {{ csrf_field() }}

                <div class="form-group row">
                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                        <label for="nom">Nom de la région</label>
                        <input id="nom" class="form-control" name="nom" type="text" placeholder="Nom" value="{{ old("nom") }}">
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <button class="btn btn-sm btn-outline-success">Créer la région</button>
                </div>
            </form>

        </div>
    </div>
@endsection
