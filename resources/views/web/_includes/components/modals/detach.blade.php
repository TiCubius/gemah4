<form id="{{ $id }}" class="modal fade" action="{{ $route }}" method="POST" tabindex="-1">
	{{ csrf_field() }}
	{{ method_field("DELETE") }}

	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Attention</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-center">
				<p>
					Vous êtes sur le point de désaffecter <b>{{ $name }}</b>.
					<br>
					Êtes-vous sûr de vouloir continuer ?
				</p>

				{{ $slot }}
			</div>
			<div class="modal-footer d-flex justify-content-between">
				<button type="button" class="btn btn-dark" data-dismiss="modal">Annuler</button>
				<button type="submit" class="btn btn-danger">Désaffecter {{ $name }}</button>
			</div>
		</div>
	</div>
</form>