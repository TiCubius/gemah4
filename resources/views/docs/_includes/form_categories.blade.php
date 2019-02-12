@foreach($categories as $category)

    <div class="categorie" data-categorie-parent="{{ $category->categorie_id }}">
        <label>
            @if(isset($selected) && ($selected === $category->id))
                <input class="categorie-libelle" name="categorie_id" type="radio" value="{{ $category->id }}" checked>
            @else
                <input class="categorie-libelle" name="categorie_id" type="radio" value="{{ $category->id }}">
            @endif
            {{ $category->libelle }}
        </label>
        @include("docs._includes.form_categories", ["categories" => $category->enfants])
    </div>

@endforeach
