<div class="col-12">
	<div class="d-flex flex-column">
		<div class="d-flex justify-content-between align-items-center">
			<h4>{{ $slot }}</h4>
			<div class="btn-group">
				@isset($custom)
					{{ $custom }}
				@endisset
				@isset($add)
					@hasPermission("{{$permission}}")
					<a class="btn btn-outline-primary" href="{{ route($add, $id ?? null) }}">
						<i class="fas fa-plus-circle"></i> Ajouter
					</a>
					@endHas
				@endisset
				@isset($back)
					<a class="btn btn-outline-primary" href="{{ route($back, $id ?? null) }}">
						<i class="fas fa-arrow-alt-circle-left"></i> Retour
					</a>
				@endisset
			</div>
		</div>
		<hr class="w-100">
	</div>
</div>