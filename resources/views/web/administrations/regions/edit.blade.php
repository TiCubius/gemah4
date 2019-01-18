@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.regions.index"])
			Édition de {{ $region->nom }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.administrations.regions.update", [$region]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("put") }}

				<div class="form-group">
					<label for="nom">Nom</label>
					<input id="nom" class="form-control" name="nom" type="text" placeholder="Nom" value="{{ $region->nom }}" required>
				</div>

				<div class="d-flex justify-content-center">
					<button class="btn btn-sm btn-outline-success">Éditer la région</button>
				</div>
			</form>
		</div>
	</div>
@endsection
