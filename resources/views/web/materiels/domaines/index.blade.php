@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["add" => "web.materiels.domaines.create", "permission" => "materiels/domaines/create", "back" => "web.materiels.index"])
			Gestion des domaines matériel
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
							<th>Libellé</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($domaines as $domaine)
							<tr>
								<td>{{ $domaine->libelle }}</td>
								<td>
									@hasPermission("materiels/domaines/show")
									<a href="{{ route("web.materiels.domaines.show", [$domaine]) }}">
										<button class="btn btn-sm btn-outline-primary">
											<i class="fas fa-info-circle"></i>
											Détails
										</button>
									</a>
									@endHas
									@hasPermission("materiels/domaines/edit")
									<a href="{{ route("web.materiels.domaines.edit", [$domaine]) }}">
										<button class="btn btn-sm btn-outline-primary">Éditer</button>
									</a>
									@endHas
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@endif
		</div>
	</div>
@endsection
