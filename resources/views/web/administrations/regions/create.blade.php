@extends('web._includes._master')
@php($title = "Création d'une région")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.regions.index"])
			Création d'une région
		@endcomponent

		<div class="col-12">

			<form class="mb-3" action="{{ route("web.administrations.regions.index") }}" method="POST">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="nom">Nom</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="Ex: Auvergne-Rhône-Alpes" value="{{ old("nom") }}" required>
				</div>

				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Créer</button>
				</div>
			</form>

		</div>
	</div>
@endsection
