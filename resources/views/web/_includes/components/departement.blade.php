<div class="form-group">
	@isset($optional)
		<label class="optional" for="departement_id">Département</label>
	@else
		<label for="departement_id">Département</label>
	@endisset

	<select id="departement_id" class="form-control" name="departement_id">
		<option value="">Sélectionner un Département</option>

		@foreach($academies as $academy)
			<optgroup label="{{ $academy->nom }}">
				@foreach($academy->departements as $departement)
					@if($departement->id == ($id ?? Session::get("user")->service->departement_id))
						<option selected value="{{ $departement->id }}">{{ $departement->nom }}</option>
					@else
						<option value="{{ $departement->id }}">{{ $departement->nom }}</option>
					@endif
				@endforeach
			</optgroup>
		@endforeach

	</select>
</div>