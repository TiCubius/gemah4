@extends('web._includes._master')
@php($title = "Création d'un service")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.services.index"])
			Création d'un service
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.administrations.services.index") }}" method="POST">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="nom">Nom</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="Ex: Administration" value="{{ old("nom") }}" required>
				</div>

				<div class="form-group">
					<label for="description">Description</label>
					<input id="description" class="form-control" name="description" type="text" placeholder="Ex: Possède tout les droits sur l'application" value="{{ old("description") }}" required>
				</div>

				@component('web._includes.components.departement', ['academies' => $academies, 'id' => old("department_id")])
				@endcomponent

				<div class="row">
					@foreach($groupedPermissions as $key => $group)
						<div class="col-12 col-xl-6">
							<div class="card my-3">
								<div class="card-header gemah-bg-primary">Permissions : {{ $key }}</div>
								<div class="card-body">
									@foreach($group->sortBy("libelle") as $permission)
										<td>
											<div class="custom-control custom-checkbox">
												@if(old("permissions[{$permission->id}]"))
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

				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Créer</button>
				</div>
			</form>
		</div>

	</div>
@endsection
