@extends("web._includes._master")
@section('content')

	@component('web._includes.components.title', ["back" => "web.index"])
		Liste des conventions

		@slot("custom")
			<div class="btn-group">
				<div class="btn btn-outline-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Gestion des conventions
				</div>

				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
					<a class="dropdown-item" href="{{ route("web.conventions.signatures_effectues") }}">Liste des responsables ayant signé</a>
					<a class="dropdown-item" href="{{ route("web.conventions.signatures_manquantes") }}">Liste des responsables n'aynt pas signé</a>

					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="{{ route("web.conventions.impressions_toutes_conventions") }}">Impression de toutes les signatures non signé</a>

					<div class="dropdown-divider"></div>
					<a id="reset" class="dropdown-item" href="#">Remettre à zéro</a>
				</div>
			</div>
		@endslot
	@endcomponent

	<div class="row">
		<div class="col-12">
			<form method="POST" action="{{ route("web.conventions.update", ["" => $eleves]) }}">
				{{ csrf_field() }}
				{{ method_field("PATCH") }}

				<div class="row">
					@foreach($eleves as $eleve)
						<div class="col-12 col-md-6 col-lg-3 mt-3">
							<div class="card">
								<div class="card-header gemah-bg-primary">
									{{ $eleve->nom }} {{ $eleve->prenom }}
								</div>

								<div class="card-body">
									@foreach($eleve->responsables as $responsable)
										<div class="custom-control custom-checkbox" data-toggle="tooltip" data-placement="bottom" title="Signée le {{ \Carbon\Carbon::parse($responsable->pivot->date_signature)->format("d/m/Y") }}">
											@if($responsable->pivot->etat_signature )
												<input name="eleve-{{$eleve->id}}_responsable-{{ $responsable->id }}" id="eleve-{{$eleve->id}}_responsable-{{ $responsable->id }}" class="custom-control-input js-checked" type="checkbox" checked>
											@else
												<input name="eleve-{{$eleve->id}}_responsable-{{ $responsable->id }}" id="eleve-{{$eleve->id}}_responsable-{{ $responsable->id }}" class="custom-control-input js-checked" type="checkbox">
											@endif

											<label class="custom-control-label" for="eleve-{{$eleve->id}}_responsable-{{ $responsable->id }}">
												{{ $responsable->nom }} {{ $responsable->prenom }}
											</label>
										</div>
									@endforeach
								</div>
							</div>
						</div>
					@endforeach
				</div>

				<button type="submit" class="btn btn-menu btn-outline-primary float-right my-3">Enregistrer</button>
			</form>
		</div>
	</div>

@endsection

@section("scripts")
	<script>
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		})
	</script>
	<script>
		document.querySelector(`#reset`).addEventListener(`click`, () => {
			let inputs = document.querySelectorAll('.js-checked')
			for (let i = 0; i < inputs.length; i++) {
				inputs[i].checked = false
			}
		})
	</script>

@endsection
