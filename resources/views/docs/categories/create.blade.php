@extends('docs._includes._master')
@section('content')
    <form id="form" action="{{ route("categories.store") }}" method="POST">
        @csrf

        <input name="libelle" type="text" placeholder="Titre de la catégorie" value="{{ old("libelle") }}" required>

        <div class="categories">

            <h4>Catégorie</h4>
            <div class="categorie">
                <label>
                    <input type="radio" name="categorie_id" value="">
                    Aucun parent
                </label>
                @include("docs._includes.form_categories", ["categories" => $categories])
            </div>
        </div>

    </form>
@endsection

@section("sidebar")
    @hasPermission("documentations/categories/create")
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
