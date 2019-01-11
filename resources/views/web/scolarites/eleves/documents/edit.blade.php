@extends('web._includes._master')

@section('content')

    <div class="row">
        @component("web._includes.components.title", ["back" => "web.scolarites.eleves.documents.index", "id" => [$eleve]])
            Édition de {{ $document->nom }}
        @endcomponent

    </div>

    <!-- enctype="multipart/form-data" permet l'envoie de fichiers -->
    <form action="{{ route('web.scolarites.eleves.documents.update', [$eleve  ->id, $document->id]) }}" method="POST"
          enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}

        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="type">Type de Document</label>
                    <select name="type" id="type" class="form-control" required>
                        <option disabled value="MDPH">Décision MDPH</option>
                        <option selected value="autre">Autre</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 js-other">
                <div class="form-group">
                    <label for="nom">Nom du document</label>
                    <input type="text" id="nom" name="nom" placeholder="Nom du Document" class="form-control"
                           value="{{ $document->nom ?? '' }}">
                </div>
            </div>

            <div class="col-sm-12 col-md-6 js-other">
                <div class="form-group">
                    <label for="description">Description du document</label>
                    <input type="text" id="description" name="description" placeholder="Description du Document"
                           class="form-control" value="{{ $document->description ?? '' }}">
                </div>
            </div>

            <div class="col-sm-12 js-mdph js-other">
                <label for="file">Fichier</label>
                <div class="form-group">
                    <div class="custom-file">
                        <input id="file" name="file" type="file" class="custom-file-input">
                        <label class="custom-file-label" for="file">Choisissez un fichier</label>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-3 js-mdph js-other">
                <button class="btn btn-outline-success btn-sm float-right" type="submit">
                    Modifier le document
                </button>
                <button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#modal">
                    Supprimer {{ $document->nom }}</button>
            </div>
        </div>
    </form>

    @component("web._includes.components.modals.destroy", ["route" => "web.scolarites.eleves.documents.destroy", "id" => [$eleve, $document]])
        @slot("name")
            {{ "{$document->nom}" }}
        @endslot
    @endcomponent
@endsection

@include("web._includes.sidebars.eleve")
