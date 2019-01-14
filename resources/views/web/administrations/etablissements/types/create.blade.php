@extends('web._includes._master')
@section('content')
    <div class="row">

        @component("web._includes.components.title", ["back" => "web.administrations.index"])
            Création d'un type d'établissement
        @endcomponent

        <div class="col-12">
            <form class="mb-3" action="{{ route("web.administrations.etablissements.types.index") }}" method="POST">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input id="nom" class="form-control" name="nom" type="text" placeholder="Nom" value="{{ old("nom") }}" required>
                </div>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-sm btn-outline-success">Créer le type d'établissement</button>
                </div>
            </form>
        </div>

    </div>
@endsection
