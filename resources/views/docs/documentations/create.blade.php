@extends('docs._includes._master')
@php($title = "Nouvelle documentation")
@section('content')

	<form id="form" action="{{ route("documentations.store") }}" method="POST">
		@csrf

		<input name="libelle" type="text" placeholder="Titre de la documentation" value="{{ old("libelle") }}">

		<div class="categories">
			<h4>Catégorie</h4>
			@include("docs._includes.form_categories", ["categories" => $categories])
		</div>

		<textarea name="contenu">{{ old("contenu") }}</textarea>
	</form>

@endsection

@section("sidebar")
	@hasPermission("documentations/documentations/create")
	<h4 id="submit">Enregistrer la documentation</h4>
	@endHas
@endsection

@section("scripts")
	<script>
		new SimpleMDE({
			spellChecker: false,
		})

		document.querySelector(`#submit`).addEventListener(`click`, () => {
			document.querySelector(`#form`).submit()
		})
	</script>
@endsection
