<div class="form-group">
	<label class="{{ isset($optional) ? "optional" : null }}" for="{{ $name }}">{{ $slot }}</label>
	<input id="{{ $name }}" class="form-control" name="{{ $name }}" type="{{ $type ?? "text" }}" placeholder="{{ $placeholder ?? null }}" value="{{ request($name) ?? $value ?? null }}" {{ isset($optional) ? "" : "required" }}>
</div>