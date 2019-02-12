@extends('docs._includes._master')
@section('content')

	<div id="content">
		<div class="title">
			<h2>Liste des documentations</h2>
			@hasPermission("documentations/documentations/create")
			<a href="{{ route("documentations.create") }}">
				<button>Nouvelle documentation</button>
			</a>
			@endHas
		</div>

		<table>
			<thead>
				<tr>
					<th>Libellé</th>
					<th>Catégorie parente</th>
					<th width="200px">Actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($documentations as $documentation)
					<tr>
						<td>{{ $documentation->libelle }}</td>
						<td>{{ $documentation->categorie->libelle }}</td>
						<td style="display: flex;">
							@hasPermission("documentations/documentations/show")
							<a href="{{ route("documentations.show", [$documentation]) }}">
								<button>Afficher</button>
							</a>
							@endHas

							@hasPermission("documentations/documentations/edit")
							<a href="{{ route("documentations.edit", [$documentation]) }}">
								<button>Éditer</button>
							</a>
							@endHas

							@hasPermission("documentations/documentations/destroy")
							<form action="{{ route("documentations.destroy", [$documentation]) }}" method="POST">
								@csrf
								@method("DELETE")

								<button>Supprimer</button>
							</form>
							@endHas
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

@endsection
