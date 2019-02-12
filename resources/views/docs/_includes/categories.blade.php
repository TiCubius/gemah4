@foreach($categories as $category)

    <div class="categorie" data-categorie-parent="{{ $category->categorie_id }}">
        <h4 class="categorie-libelle">{{ $category->libelle }}</h4>

        @include("docs._includes.categories", ["categories" => $category->enfants])

        @foreach($category->documentations as $documentation)
            <a class="categorie categorie-link" href="{{ route("documentations.show", [$documentation]) }}" data-categorie-parent="{{ $documentation->categorie_id }}">{{ $documentation->libelle }}</a>
        @endforeach

    </div>

@endforeach
