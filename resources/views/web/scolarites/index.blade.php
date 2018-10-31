@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.index"])
			Gestion de la Scolarité
		@endcomponent

			<div class="col-12">
				<a href="{{ "" }}">
					<button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
						Gestion des Élèves
					</button>
				</a>

				<a href="{{ "" }}">
					<button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
						Gestion des Établissements
					</button>
				</a>

				<a href="{{ "" }}">
					<button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
						Gestion des Enseignants
					</button>
				</a>
			</div>
	</div>
@endsection
