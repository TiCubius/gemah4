@extends('web._includes._master')@php($title = "Personnalisation des conventions")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.index"])
			Personnalisation des conventions du département : {{ $departement->nom }}
		@endcomponent

		<div class="col-12">
			<form action="{{ route("web.administrations.parametres.update") }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				{{ method_field("PATCH") }}

				<div class="row">
					@foreach($groupedParametres as $key => $group)
						<div class="col-12 col-lg-6">
							<div class="card mb-3">
								<div class="card-header gemah-bg-primary">Paramètres : {{ $key }}</div>
								<div class="card-body">
									@foreach($group as $parametre)
										@component("web._includes.components.parameter_textaera", ["optional" => true, "name" => $parametre->key, "value" => $parametre->value])
											{{ $parametre->libelle }}
										@endcomponent
									@endforeach
								</div>
							</div>
						</div>
					@endforeach
				</div>

				<div class="card mb-3">
					<div class="card-header gemah-bg-primary">Changement des images de la convention</div>
					<div class="card-body">

						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">Image Marianne (optionel)</span>
							</div>
							<div class="custom-file">
								<input id="marianne" class="custom-file-input" type="file" name="marianne">
								<label class="custom-file-label js-marianne" for="marianne">Choose file</label>
							</div>
						</div>


						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text">Image DSDEN (optionel)</span>
							</div>
							<div class="custom-file">
								<input id="dsden" class="custom-file-input" type="file" name="dsden">
								<label class="custom-file-label js-dsden" for="dsden">Choose file</label>
							</div>
						</div>
					</div>
				</div>


				<div class="float-right mb-3">
					<button class="btn btn-sm btn-outline-primary">Éditer</button>
				</div>
			</form>

		</div>
	</div>
@endsection

