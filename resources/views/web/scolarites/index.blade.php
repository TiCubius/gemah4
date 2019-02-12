@extends('web._includes._master')
@php($title = "Gestion de la scolarité")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.index"])
			Gestion de la scolarité
		@endcomponent

		<div class="col-12">
			@hasPermission("eleves/index")
			<a href="{{ route("web.scolarites.eleves.index") }}">
				<button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
					Gestion des élèves
				</button>
			</a>
			@endHas

			@hasPermission("etablissements/index")
			<a href="{{ route("web.scolarites.etablissements.index") }}">
				<button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
					Gestion des établissements
				</button>
			</a>
			@endHas

			@hasPermission("enseignants/index")
			<a href="{{ route("web.scolarites.enseignants.index") }}">
				<button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
					Gestion des enseignants référents
				</button>
			</a>
			@endHas
		</div>
	</div>
@endsection
