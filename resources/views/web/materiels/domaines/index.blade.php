@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["add" => "web.materiels.domaines.create", "back" => "web.materiels.index"])
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
									<a href="{{ route("web.materiels.domaines.edit", [$domaine]) }}">
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
