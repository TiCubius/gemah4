<div id="modal" class="modal fade" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Attention</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body text-center">
				<p class="mb-0">
					{{ $type }} que vous souhaitez ajouter <b>semble déjà exister</b>
					<br>
					Souhaitez-vous tout de même continuer ?
				</p>
				{{ $slot }}
			</div>
			<div class="modal-footer d-flex justify-content-between">
				<button type="button" class="btn btn-dark" data-dismiss="modal">Annuler</button>
				<button class="btn btn-danger js-force-submit"><i class="fas fa-exclamation-circle"></i> Forcer la création</button>
			</div>
		</div>
	</div>
</div>