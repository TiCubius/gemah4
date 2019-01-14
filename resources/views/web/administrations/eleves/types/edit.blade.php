@extends('web._includes._master')
@section('content')
    <div class="row">

        @component("web._includes.components.title", ["back" => "web.administrations.services.index"])
            Édition de {{ $type->nom }}
        @endcomponent

        <div class="col-12">
            <form class="mb-3" action="{{ route("web.administrations.eleves.types.update", [$type]) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field("put") }}

                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input id="nom" class="form-control" name="nom" type="text" placeholder="Nom"
                           value="{{ $type->nom }}" required>
                </div>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#modal">Supprimer</button>
                    <button class="btn btn-sm btn-outline-success">Éditer</button>
                </div>
            </form>
        </div>
    </div>

    @component("web._includes.components.modals.destroy", ["route" => "web.administrations.eleves.types.destroy", "id" => $type])
        @slot("name")
            {{ $type->nom }}
        @endslot
    @endcomponent

@endsection
