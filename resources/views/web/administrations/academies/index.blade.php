@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["add" => "web.administrations.academies.create", "back" => "web.administrations.index"])
			Gestion des Académies
		@endcomponent

		<div class="col-12">
			@if($academies->isEmpty())
				<div class="alert alert-warning">
					Aucune académie n'est enregistré sur l'application
				</div>
			@else
				<table class="table table-sm table-hover text-center">
					<thead class="gemah-bg-primary">
						<tr>
							<th>Nom</th>
							<th>Région</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($academies as $academy)
							<tr>
								<td>{{ $academy->nom }}</td>
								<td>{{ $academy->region->nom }}</td>
								<td>
									<a href="{{ route("web.administrations.academies.edit", [$academy->id]) }}">
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
