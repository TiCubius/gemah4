<div class="col-12">
	<div class="d-flex flex-column">
		<div class="d-flex justify-content-between align-items-center">
			<h4>{{ $slot }}</h4>
			<div>
				@isset($add)
					<a href="{{ route($add, $id ?? null) }}">
						<button class="btn btn-outline-primary">Ajouter</button>
					</a>
				@endif
				@isset($back)
					<a href="{{ route($back, $id ?? null) }}">
						<button class="btn btn-outline-primary">Retour</button>
					</a>
				@endif
			</div>
		</div>
		<hr class="w-100">
	</div>
</div>