@extends('emails._includes._master')

@section('content')
	<div class="alert alert-info">
		<h4 class="alert-heading">Information : Nouvelle décision !</h4>
		<p>Une nouvelle décision vient d'être ajoutée pour <b>{{ $eleve->nom . ' ' . $eleve->prenom }}</b></br>
			Il s'agit d'une decision concernant un élève de type {{ join(" / ",$eleve->types->pluck("libelle")->toArray()) }}</p>
		<hr>
		<p class="small text-muted mb-0">Ceci est un message automatique, merci de ne pas y répondre</p>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="card mb-3 d-block">
				<div class="card-header gemah-bg-primary">
					Informations sur l'élève
					<div class="float-right">
						@foreach($eleve->types as $type)
							<div class="badge badge-success m-0">{{ $type->libelle }}</div>
						@endforeach
					</div>
				</div>

				<div class="card-body d-block">
					<strong>Nom</strong>: {{ $eleve->nom }} <br>
					<strong>Prénom</strong>: {{ $eleve->prenom }} <br>
					<strong>Date de naissance</strong>
					{{ \Carbon\Carbon::parse($eleve->date_naissance)->format('d/m/Y') }} <br>
					<strong>Classe</strong>: {{ $eleve->classe }}
				</div>

				<div class="card-footer text-center d-block">
					<a href="{{ route('web.scolarites.eleves.show', [$eleve->id]) }}">
						<button class="btn btn-sm btn-outline-primary">
							Profil de l'élève
						</button>
					</a>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card d-block">
				<div class="card-header gemah-bg-primary">Informations sur le document</div>
				<div class="card-body d-block">
					<p class="mb-0"><b>Nom</b>: {{ $decision->document->nom }}</p>
				</div>
				<div class="card-footer text-center d-block">
					<a href="{{ route('web.scolarites.eleves.documents.index', $eleve->id) }}">
						<button class="btn btn-sm btn-outline-primary">
							Voir documents
						</button>
					</a>
				</div>
			</div>
		</div>
	</div>
@endsection
