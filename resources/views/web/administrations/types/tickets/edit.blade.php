@extends('web._includes._master')
@php($title = "Édition de {$ticket->libelle}")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.administrations.types.tickets.index"])
			Édition de {{ $ticket->libelle }}
		@endcomponent

		<div class="col-12">

			<form class="mb-3" action="{{ route("web.administrations.types.tickets.update", [$ticket]) }}" method="POST">
				{{ csrf_field() }}
				{{ method_field("put") }}

				@component("web._includes.components.input", ["name" => "libelle", "placeholder" => "Ex: Appel téléphonique", "value" => $ticket->libelle])
					Libellé
				@endcomponent


				@component("web._includes.components.form_edit")
				@endcomponent
			</form>
		</div>
	</div>

	@component("web._includes.components.modals.destroy", ["route" => "web.administrations.types.tickets.destroy", "id" => $ticket])
		@slot("name")
			{{ $ticket->libelle }}
		@endslot
	@endcomponent

@endsection
