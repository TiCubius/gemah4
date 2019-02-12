@extends('docs._includes._master')
@php($title = "Édition de {$categorie->libelle}")
@section('content')
    <form id="form" action="{{ route("categories.update", [$categorie]) }}" method="POST">
        @csrf
        @method("PATCH")

        <input name="libelle" type="text" placeholder="Titre de la catégorie" value="{{ $categorie->libelle }}" required>

        <div class="categories">

            <h4>Catégorie</h4>
            <div class="categorie">
                <label>
                    <input type="radio" name="categorie_id" value="">
                    Aucun parent
                </label>
                @include("docs._includes.form_categories", ["categories" => $categories, "selected" => $categorie->categorie_id])
            </div>
        </div>

    </form>
@endsection

@section("sidebar")
    @hasPermission("documentations/categories/edit")
    <h4 id="submit">Enregistrer la catégorie</h4>
    @endHas
@endsection

@section("scripts")
    <script>
        document.querySelector(`#submit`).addEventListener(`click`, () => {
            document.querySelector(`#form`).submit()
        })
    </script>
@endsection
