@extends('web._includes._master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center">
                    <h4>Édition de {{ $Region->nom }}</h4>
                    <a href="{{ route("web.administrations.regions.index") }}">
                        <button class="btn btn-outline-primary">Retour</button>
                    </a>
                </div>
                <hr class="w-100">
            </div>
        </div>

        <div class="col-12">
            <form class="mb-3" action="{{ route("web.administrations.regions.update", [$Region->id]) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field("put") }}

                <div class="form-group row">
                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                        <label for="nom">Nom de la région</label>
                        <input id="nom" class="form-control" name="nom" type="text" placeholder="Nom" value="{{ $Region->nom }}" required>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <button class="btn btn-sm btn-outline-success">Éditer la région</button>
                </div>
            </form>
        </div>
    </div>
@endsection
