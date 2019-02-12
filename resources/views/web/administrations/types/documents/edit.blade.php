@extends('web._includes._master')
@php($title = "Édition de {$document->libelle}")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.types.documents.index"])
			Édition de {{ $document->libelle }}
		@endcomponent

		<div class="col-12">
			<form class="mb-3" action="{{ route("web.administrations.types.documents.update", [$document]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("put") }}

				@component("web._includes.components.input", ["name" => "libelle", "placeholder" => "Ex: Matériel", "value" => $document->libelle])
					Libellé
				@endcomponent

				@component("web._includes.components.form_edit")
				@endcomponent
			</form>
		</div>
	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.administrations.types.documents.destroy", "id" => $document])
		@slot("name")
			{{ $document->libelle }}
		@endslot
	@endcomponent

@endsection
