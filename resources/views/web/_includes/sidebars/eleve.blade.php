@section("sidebar")
	<div class="row">
		<a href="{{ route('web.scolarites.eleves.show', [$eleve]) }}" class="btn btn-outline-primary col-12 mb-1">Profil</a>
		<a href="{{ route('web.scolarites.eleves.documents.index', [$eleve]) }}" class="btn btn-outline-primary col-12 mb-1">Documents</a>
		<a href="{{ route("web.scolarites.eleves.tickets.index", [$eleve]) }}" class="btn btn-outline-primary col-12 mb-1">Tickets</a>
	</div>
@endsection

@section("navbar")

	<div class="navbar-nav ml-auto d-xl-none">
		<hr class="w-100" style="border: 1px solid white;">
		<a href="{{ route('web.scolarites.eleves.show', [$eleve]) }}" class="btn btn-outline-light col-12 mb-1">Profil</a>
		<a href="{{ route('web.scolarites.eleves.documents.index', [$eleve]) }}" class="btn btn-outline-light col-12 mb-1">Documents</a>
		<a href="{{ route("web.scolarites.eleves.tickets.index", [$eleve]) }}" class="btn btn-outline-light col-12 mb-1">Tickets</a>
	</div>
@endsection