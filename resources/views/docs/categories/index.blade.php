@extends('docs._includes._master')
@section('content')

	<div id="content">
		<div class="title">
			<h2>Liste des catégories</h2>

			@hasPermission("documentations/categories/create")
			<a href="{{ route("categories.create") }}">
				<button>Nouvelle catégorie</button>
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
				@foreach($categoriesList as $category)
					<tr>
						<td>{{ $category->libelle }}</td>
						<td>{{ $category->parent ? $category->parent->libelle : "" }}</td>
						<td style="display: flex;">
							@hasPermission("documentations/categories/edit")
							<a href="{{ route("categories.edit", [$category]) }}">
								<button>Éditer</button>
							</a>
							@endHas

							@hasPermission("documentations/categories/destroy")
							<form action="{{ route("categories.destroy", [$category]) }}" method="POST">
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
