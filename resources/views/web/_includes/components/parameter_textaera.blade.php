<div class="form-group">
    <label class="{{ isset($optional) ? "optional" : null }}" for="{{ $name }}">{{ $slot }}</label>
    <textarea id="{{ $name }}" class="form-control"  name="{{ $name }}" type="{{ $type ?? "text" }}" placeholder="{{ $placeholder ?? null }}" {{ isset($optional) ? "" : "required" }}>{{ request($name) ?? old($name) ?? $value ?? null }}</textarea>
</div>