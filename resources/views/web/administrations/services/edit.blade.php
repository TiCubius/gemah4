@extends('web._includes._master')
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Édition de {{ $Service->nom }}</h4>
                    <a href="{{ route("web.administrations.services.index") }}">
                        <button class="btn btn-outline-primary">Retour</button>
                    </a>
                </div>
                <hr class="w-100">
            </div>
        </div>

        <div class="col-12">

            <form class="mb-3" action="{{ route("web.administrations.services.update", [$Service->id]) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field("put") }}

                <div class="form-group row">
                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                        <label for="nom">Nom du service</label>
                        <input id="nom" class="form-control" name="nom" type="text" placeholder="Nom" value="{{ $Service->nom }}">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                        <label for="description">Description du service</label>
                        <input id="description" class="form-control" name="description" type="text" placeholder="Description" value="{{ $Service->description }}">
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <button class="btn btn-sm btn-outline-success">Éditer le service</button>
                </div>
            </form>

        </div>
    </div>
@endsection
