@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.statistiques.index"])
			Liste des élèves dont la décision à expiré
		@endcomponent

	<div class="table-responsive mb-3">
		<table id="table" class="table table-hover table-sm table-striped text-center">
			<thead class="gemah-bg-primary">
				<tr class="text-center">
					<th>Nom</th>
					<th>Prénom</th>
					<th>Date limite convention</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach($eleves as $eleve)
					<tr>
						<td>{{ $eleve->nom }}</td>
						<td>{{ $eleve->prenom }}</td>
						<td>{{ $eleve->decisions->sortByDesc("date_limite")->first()->date_limite}}</td>
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
@endsection
