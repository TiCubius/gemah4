@extends('web._includes._master')
@section('content')
	<div class="row">

		<div class="col-12 text-center">
			<h2>Bienvenue sur <strong>GEMAH</strong> <span class="text-muted small">3.0</span></h2>
			<h5>L'application de <strong>ge</strong>stion de prêt de <strong>ma</strong>tériel aux enfants en situation de <strong>h</strong>andicap.</h5>
			<hr class="w-100">
		</div>

		<div class="col-12">
			<a href="#">
				<button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
					Gestion des Elèves
				</button>
			</a>

			<a href="{{ route("web.responsables.index") }}">
				<button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
					Gestion des Responsables
				</button>
			</a>

			<a href="{{ route("web.materiels.index") }}">
				<button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
					Gestion du Matériel
				</button>
			</a>

			<a href="#">
				<button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
					Statistiques
				</button>
			</a>

			<a href="{{ route('web.administrations.index') }}">
				<button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
					Administrations
				</button>
			</a>
		</div>

	</div>
@endsection
