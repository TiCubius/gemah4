<div class="form-group">
    <label class="optional" for="departement_id">Département</label>

    <select id="departement_id" class="form-control" name="departement_id">
        <option value="" hidden>Sélectionner un Département</option>

        @foreach($academies as $academy)
            <optgroup label="{{ $academy->nom }}">
                @foreach($academy->departements as $departement)
                    @if($departement->id == ($id ?? null))
                        <option selected value="{{ $departement->id }}">{{ $departement->nom }}</option>
                    @else
                        <option value="{{ $departement->id }}">{{ $departement->nom }}</option>
                    @endif
                @endforeach
            </optgroup>
        @endforeach

    </select>
</div>