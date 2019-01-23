@extends("web._includes._master")
@section("content")
	<div class="row">

		@component("web._includes.components.title", ["add" => "web.administrations.materiels.etats.administratifs.create", "back" => "web.administrations.index"])
			Gestion des états administratifs matériel
		@endcomponent

		<div class="col-12">
			@if($etats->isEmpty())
				<div class="alert alert-warning">
					Aucun état administratif matériel n'est enregistré sur l'application
				</div>
			@else
				<table class="table table-sm table-hover text-center">
					<thead class="gemah-bg-primary">
						<tr>
							<th>Couleur</th>
							<th>Libellé</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($etats as $etat)
							<tr>
								<td style="background: {{ $etat->couleur }};"></td>
								<td>{{ $etat->libelle }}</td>
								<td>
									<a href="{{ route("web.administrations.materiels.etats.administratifs.edit", [$etat]) }}">
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