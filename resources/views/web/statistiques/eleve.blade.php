@extends('web._includes._master')

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.statistiques.index"])
			Liste des élèves
		@endcomponent
		<div class="col-12">
			<form class="mb-3">
				<div class="card mb-3">
					<div class="card-header gemah-bg-primary d-flex justify-content-between">
						Recherche :

						<a data-toggle="collapse" href="#option_recherche" aria-expanded="true" aria-controls="option_recherche" id="recherche" style="text-decoration:none; color:#FFFFFF">
							<i class="fa fa-chevron-down pull-right"></i>
						</a>
					</div>

					<div id="option_recherche" class="collapse show" aria-labelledby="recherche">
						<div class="card-body row">
							<div class="col-md-6 col-12">
								@component("web._includes.components.departement", ["optional" => true, "academies" => $academies, "id" => app("request")->input("departement_id")])
								@endcomponent
							</div>

							<div class="col-md-6 col-12">
								@component("web._includes.components.types_decisions",["optional" => true, "types" => $types, "id" => app("request")->input("type_eleve_id")])
								@endcomponent
							</div>

							<div class="col-md-6 col-12">
								@component("web._includes.components.input", ["optional" => true, "name" => "nom", "placeholder" => "Ex: SMITH"])
									Nom
								@endcomponent
							</div>

							<div class="col-md-6 col-12">
								@component("web._includes.components.input", ["optional" => true, "name" => "prenom", "placeholder" => "Ex: John"])
									Prénom
								@endcomponent
							</div>
						</div>
					</div>
				</div>

				<div class="card mb-3">
					<div class="card-header gemah-bg-primary d-flex justify-content-between">
						Filtres :

						<a data-toggle="collapse" href="#option_filtre" aria-expanded="true" aria-controls="option_filtre" id="filtre" style="text-decoration:none; color:#FFFFFF">
							<i class="fa fa-chevron-down pull-right"></i>
						</a>
					</div>

					<div id="option_filtre" class="collapse show" aria-labelledby="filtre">
						<div class="card-body row">
							<div class="col-12 col-lg-6">
								@component("web._includes.components.filtre", ["optional" => true, "name" => "etablissement"])
									<option value="with">Avec</option>
									<option value="without">Sans</option>
								@endcomponent
							</div>
							<div class="col-12 col-lg-6">
								@component("web._includes.components.filtre", ["optional" => true, "name" => "materiels"])
									<option value="with">Avec</option>
									<option value="without">Sans</option>
								@endcomponent
							</div>
							<div class="col-12 col-lg-6">
								@component("web._includes.components.filtre", ["optional" => true, "name" => "responsables"])
									<option value="with">Avec</option>
									<option value="without">Sans</option>
								@endcomponent
							</div>
							<div class="col-12 col-lg-6">
								@component("web._includes.components.filtre", ["optional" => true, "name" => "documents"])
									<option value="with">Avec</option>
									<option value="without">Sans</option>
								@endcomponent
							</div>
							<div class="col-12">
								@component("web._includes.components.filtre", ["optional" => true, "name" => "ordre"])
									<option value="ASC/created_at">Ordre croissant de création</option>
									<option value="DESC/created_at">Ordre décroissant de création</option>
									<option value="ASC/date_naissance">Ordre croissant de date de naissance</option>
									<option value="DESC/date_naissance">Ordre décroissant de date de naissance</option>
									<option value="ASC/updated_at">Ordre croissant de modification</option>
									<option value="DESC/updated_at">Odre décroissant de modification</option>
									<option value="ASC/alphabetique">Ordre alphabétique [A-Z]</option>
									<option value="DESC/alphabetique">Ordre alphabétique inversé [Z-A]</option>
								@endcomponent
							</div>
						</div>
					</div>
				</div>

				<div class="actions d-flex justify-content-between">
					<a class="btn btn-outline-dark" href="{{ route("web.statistiques.eleves") }}">
						Annuler la recherche
					</a>
					<button class="btn btn-outline-dark">Rechercher</button>
				</div>
			</form>

			<div class="mt-3">
				@component("web._includes.components.alert", ["type" => "success"])
					<b>Information(s) sur la recherche</b> <br>
					<ul class="mb-0">
						<li>
							Nombre d'élèves: {{ count($eleves) }}
						</li>
					</ul>
				@endcomponent
			</div>

			<div class="table-responsive mb-3">
				<table id="table" class="table table-hover table-sm table-striped text-center">
					<thead class="gemah-bg-primary">
						<tr class="text-center">
							<th>Nom</th>
							<th>Prénom</th>
							<th>Date de naissance</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($eleves as $eleve)
							<tr>
								<td>{{ $eleve->nom }}</td>
								<td>{{ $eleve->prenom }}</td>
								<td>{{ $eleve->date_naissance->format("d/m/Y") }}</td>
								<td>
									<a class="btn btn-sm btn-outline-primary" href="{{ route("web.scolarites.eleves.show", [$eleve]) }}">
										Détails
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection

@section("scripts")
	<script>
		$(document).ready(function () {
			$('#table').DataTable({
				"language": {
					"url": "{{ asset("assets/js/dataTables.french.json") }}",
				},
				"info": false,
				"columnDefs": [
					{"orderable": false, "targets": 3},
				],
				"pageLength": 50,
			})
		})
	</script>
@endsection