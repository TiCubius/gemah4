<div class="form-group">
	<label class="optional" for="type_etablissement_id">Type</label>

	<select id="type_etablissement_id" class="form-control" name="type_etablissement_id">
		<option value="" hidden>Choisissez un type d'établissement</option>

		@foreach($types as $type)
			@if($type->id === ($id ?? null))
				<option value="{{ $type->id }}" selected>{{ "{$type->libelle}" }}</option>
			@else
				<option value="{{ $type->id }}">{{ "{$type->libelle}" }}</option>
			@endif
		@endforeach

	</select>
</div>