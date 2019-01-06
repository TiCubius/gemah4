@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["add" => "web.administrations.services.create", "back" => "web.administrations.index"])
			Gestion des services
		@endcomponent

		<div class="col-12">
			@if($services->isEmpty())
				<div class="alert alert-warning">
					Aucun service n'est enregistré sur l'application
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
						@foreach($services as $service)
							<tr>
								<td>{{ $service->nom }}</td>
								<td>
									<a href="{{ route("web.administrations.services.edit", [$service]) }}">
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
