@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["add" => "web.materiels.domaines.create", "back" => "web.materiels.index"])
			Gestion des Domaines Matériel
		@endcomponent

		<div class="col-12">
			@if($domaines->isEmpty())
				<div class="alert alert-warning">
					Aucun domaine n'est enregistré sur l'application
				</div>
			@else
				<table class="table table-sm table-hover text-center">
					<thead class="gemah-bg-primary">
						<tr>
							<th>Nom</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($domaines as $domaine)
							<tr>
								<td>{{ $domaine->nom }}</td>
								<td>
									<a href="{{ route("web.materiels.domaines.edit", [$domaine->id]) }}">
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
