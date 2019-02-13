@extends('web._includes._master')
@php($title = "Édition de {$service->nom}")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.services.index"])
			Édition de {{ $service->nom }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.administrations.services.update", [$service]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("put") }}

				@component("web._includes.components.input", ["name" => "nom", "placeholder" => "Ex: Administration", "value" => $service->nom])
					Nom
				@endcomponent

				@component("web._includes.components.input", ["name" => "description", "placeholder" => "Ex: Gestion de GEMAH", "value" => $service->description])
					Description
				@endcomponent

				@component('web._includes.components.departement', ['academies' => $academies, 'id' => $service->departement_id])
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

				@component("web._includes.components.form_edit")
				@endcomponent
			</form>
		</div>
	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.administrations.services.destroy", "id" => $service])
		@slot("name")
			{{ $service->nom }}
		@endslot
	@endcomponent

@endsection
