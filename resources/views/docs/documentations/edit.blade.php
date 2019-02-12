@extends('docs._includes._master')
@php($title = "Édition de {$documentation->libelle}")
@section('content')

    <form id="form" action="{{ route("documentations.update", [$documentation]) }}" method="POST">
        @csrf
        @method("PATCH")

        <input name="libelle" type="text" placeholder="Titre de la documentation" value="{{ $documentation->libelle }}">

        <div class="categories">
            <h4>Catégorie</h4>
            @include("docs._includes.form_categories", ["categories" => $categories, "selected" => $documentation->categorie_id])
        </div>

        <textarea name="contenu">{{ $documentation->contenu }}</textarea>
    </form>

@endsection

@section("sidebar")
    @hasPermission("documentations/documentations/edit")
    <h4 id="submit">Enregistrer la documentation</h4>
    @endHas
@endsection

@section("scripts")
    <script>
        new SimpleMDE({
            spellChecker: false
        })

        document.querySelector(`#submit`).addEventListener(`click`, () => {
            document.querySelector(`#form`).submit()
        })
    </script>
@endsection
