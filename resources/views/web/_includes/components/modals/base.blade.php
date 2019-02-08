<form id="modal" class="modal fade" action="{{ route("$route", ($id ?? null)) }}" method="{{ $method ?? "POST" }}" tabindex="-1">
	@empty($method)
	{{ csrf_field() }}
	@endempty

	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">{{ $title }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-center">
				{{ $slot }}
			</div>
			<div class="modal-footer d-flex justify-content-between">
				<button type="button" class="btn btn-dark" data-dismiss="modal">Annuler</button>
				<button type="submit" class="btn btn-primary">{{ $action ?? "Continuer" }}</button>
			</div>
		</div>
	</div>
</form>