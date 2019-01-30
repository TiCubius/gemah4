@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["add" => "web.administrations.types.documents.create", "permission" => "administrations/types/documents/create", "back" => "web.administrations.index"])
			Gestion des types de document
		@endcomponent

		<div class="col-12">
			@if($types_documents->isEmpty())
				<div class="alert alert-warning">
					Aucun type d'élève n'est enregistré sur l'application
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
						@foreach($types_documents as $type_documents)
							<tr>
								<td>{{ $type_documents->libelle }}</td>
								<td>
									<a href="{{ route("web.administrations.types.documents.edit", [$type_documents]) }}">
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
