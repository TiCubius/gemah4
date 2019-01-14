<div class="form-group">
    <label class="optional" for="type_eleve_id">Type</label>

    <select id="type_eleve_id" class="form-control" name="type_eleve_id">
        <option value="" hidden>Choisissez un type d'élève</option>

        @foreach($types as $type)
            @if($type->id == ($id ?? null))
                <option value="{{ $type->id }}" selected>{{ "{$type->nom}" }}</option>
            @else
                <option value="{{ $type->id }}">{{ "{$type->nom}" }}</option>
            @endif
        @endforeach

    </select>
</div>