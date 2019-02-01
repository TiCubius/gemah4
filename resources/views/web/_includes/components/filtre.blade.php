<div class="form-group">
	<label class="{{ $optional ? "optional" : "" }}" for="{{ $name }}">{{ ucfirst($name) }}</label>

	<select id="{{ $name }}" class="form-control" name="{{ $name }}">
		<option value="">Veuillez sélectionner une valeur...</option>

		{{ $slot }}

	</select>
</div>