<div class="form-group">
	<label class="{{ isset($optional) ? "optional" : "" }}" for="type_eleve_id">Type</label>

	<select id="type_eleve_id" class="form-control" name="type_eleve_id" {{ isset($optional) ? "" : "required" }}>
		<option value="">Choisissez un type d'élève</option>

		@foreach($types as $type)
			@if($type->id == ($id ?? null))
				<option value="{{ $type->id }}" selected>{{ "{$type->libelle}" }}</option>
			@else
				<option value="{{ $type->id }}">{{ "{$type->libelle}" }}</option>
			@endif
		@endforeach

	</select>
</div>