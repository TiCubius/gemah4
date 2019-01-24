<div class="form-group">
	@isset($optional)
		<label class="optional" for="{{ $filter }}">{{ $filter_name }}</label>
	@else
		<label for="{{ $filter }}">{{ $filter_name }}</label>
	@endif

	<select name="{{ $filter }}" class="form-control">
		<option>Sélectionner un filtre...</option>
		@if(app("request")->input($filter) == "normal")
			<option selected value="normal">{{ $first_option }}</option>
			<option value="inverted">{{ $second_option }}</option>
		@elseif(app("request")->input($filter) == "inverted")
			<option value="normal">{{ $first_option }}</option>
			<option selected value="inverted">{{ $second_option }}</option>
		@else
			<option value="normal">{{ $first_option }}</option>
			<option value="inverted">{{ $second_option }}</option>
		@endif
	</select>
</div>