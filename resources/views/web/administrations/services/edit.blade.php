@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.services.index"])
			Édition de {{ $service->nom }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.administrations.services.update", [$service]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("put") }}

				<div class="form-group">
					<label for="nom">Nom</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="Ex: Administration" value="{{ $service->nom }}" required>
				</div>

				<div class="form-group">
					<label for="description">Description</label>
					<input id="description" class="form-control" name="description" type="text" placeholder="Ex: Possède tout les droits sur l'application" value="{{ $service->description }}" required>
				</div>

				@component('web._includes.components.departement', ['academies' => $academies, 'id' => $service->departement_id])
				@endcomponent

				<div class="row">
					@foreach($groupedPermissions as $key => $group)
						<div class="col-12 col-xl-6">
							<div class="card my-3">
								<div class="card-header gemah-bg-primary">{{ $key }}</div>
								<div class="card-body">
									@foreach($group as $permission)
										<td>
											<div class="custom-control custom-checkbox">
												@if($service->permissions->contains('id', $permission->id))
													<input id="permissions[{{ $permission->id }}]" class="custom-control-input" name="permissions[{{ $permission->id }}]" type="checkbox" checked>
												@else
													<input id="permissions[{{ $permission->id }}]" class="custom-control-input" name="permissions[{{ $permission->id }}]" type="checkbox">
												@endif
												<label class="custom-control-label" for="permissions[{{ $permission->id }}]"> {{ $permission->libelle }} </label>
											</div>
										</td>
									@endforeach
								</div>
							</div>
						</div>
					@endforeach
				</div>

				<div class="d-flex justify-content-between">
					<button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#modal">Supprimer</button>
					<button class="btn btn-sm btn-outline-success">Éditer</button>
				</div>
			</form>
		</div>
	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.administrations.services.destroy", "id" => $service])
		@slot("name")
			{{ $service->nom }}
		@endslot
	@endcomponent

@endsection
