@section("sidebar")
	{{ "{$eleve->nom} {$eleve->prenom}" }}
	<div class="row mt-3">
		<a href="{{ route('web.scolarites.eleves.show', [$eleve]) }}" class="btn btn-outline-primary col-12 mb-1">Profil</a>
		<a href="{{ route('web.scolarites.eleves.documents.index', [$eleve]) }}" class="btn btn-outline-primary col-12 mb-1">Documents</a>
		<a href="{{ route("web.scolarites.eleves.tickets.index", [$eleve]) }}" class="btn btn-outline-primary col-12 mb-1">Tickets</a>
	</div>
@endsection

@section("navbar")
	<div class="navbar-nav ml-auto d-xl-none align-items-center">
		<hr class="w-100" style="border: 1px solid white;">
		<div class="mb-3">{{ "{$eleve->nom} {$eleve->prenom}" }}</div>
		<a href="{{ route('web.scolarites.eleves.show', [$eleve]) }}" class="btn btn-outline-light col-12 mb-1">Profil</a>
		<a href="{{ route('web.scolarites.eleves.documents.index', [$eleve]) }}" class="btn btn-outline-light col-12 mb-1">Documents</a>
		<a href="{{ route("web.scolarites.eleves.tickets.index", [$eleve]) }}" class="btn btn-outline-light col-12 mb-1">Tickets</a>
	</div>
@endsection