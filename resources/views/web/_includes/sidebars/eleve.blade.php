@section("sidebar")
	<div class="row">
		<a href="{{ route('web.scolarites.eleves.show', [$eleve]) }}" class="btn btn-outline-primary col-12 mb-1">Récapitulatif</a>
		<a href="{{ route('web.scolarites.eleves.documents.index', [$eleve]) }}" class="btn btn-outline-primary col-12 mb-1">Document</a>
		<a href="{{ route("web.scolarites.eleves.materiels", [$eleve]) }}" class="btn btn-outline-primary col-12 mb-1">Matériel</a>
		<a href="{{ route("web.scolarites.eleves.tickets.index", [$eleve]) }}" class="btn btn-outline-primary col-12 mb-1">Tickets</a>
	</div>
@endsection