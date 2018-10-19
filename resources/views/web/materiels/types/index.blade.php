@extends('web._includes._master')
@section('content')
	<div class="row">

		<div class="col-12">
			<div class="d-flex flex-column">
				<div class="d-flex justify-content-between align-items-center">
					<h4>Gestion des Types Matériel</h4>
					<div>
						<a href="{{ route("web.materiels.types.create") }}">
							<button class="btn btn-outline-primary">Ajouter</button>
						</a>
						<a href="{{ route("web.materiels.index") }}">
							<button class="btn btn-outline-primary">Retour</button>
						</a>
					</div>
				</div>
				<hr class="w-100">
			</div>
		</div>

		<div class="col-12">
			@if($types->isEmpty())
				<div class="alert alert-warning">
					Aucun type n'est enregistré sur l'application
				</div>
			@else
				<table class="table table-sm table-hover text-center">
					<thead class="gemah-bg-primary">
						<tr>
							<th>Nom</th>
							<th>Domaine</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($types as $type)
							<tr>
								<th>{{ $type->nom }}</th>
								<th>{{ $type->domaine->nom }}</th>
								<td>
									<a href="{{ route("web.materiels.types.edit", [$type->id]) }}">
										<button class="btn btn-sm btn-outline-primary">Editer</button>
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@endif
		</div>
	</div>
@endsection
