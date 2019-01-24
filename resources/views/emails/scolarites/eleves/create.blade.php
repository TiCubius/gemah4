@extends('emails._includes._master')

@section('content')
    <div class="d-flex flex-column">
        <div class="alert alert-info">
            <h4 class="alert-heading">Information : Nouvel(le) élève {{ join(" / ",$eleve->types->pluck("libelle")->toArray()) }} !</h4>
            <p>Un(e) nouvel(le) élève vient d'être ajouté(e) sur GEMAH</p>
            <hr>
            <p class="small text-muted mb-0">Ceci est un message automatique, merci de ne pas y répondre</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header gemah-bg-primary d-flex justify-content-between">
            Informations sur l'élève
            <div>
                @foreach($eleve->types as $type)
                    <div class="badge badge-success m-0">{{ $type->libelle }}</div>
                @endforeach
            </div>
        </div>
        <div class="card-body">
            <strong>Nom</strong>: {{ $eleve->nom }} <br>
            <strong>Prénom</strong>: {{ $eleve->prenom }} <br>
            <strong>Date de naissance</strong>: {{ \Carbon\Carbon::parse($eleve->date_naissance)->format('d/m/Y') }} <br>
            <strong>Classe</strong>: {{ $eleve->classe }}
        </div>

        <div class="card-footer text-center">
            <a href="{{ route('web.scolarites.eleves.show', [$eleve->id]) }}">
                <button class="btn btn-sm btn-outline-primary">
                    Profil de l'élève
                </button>
            </a>
        </div>
    </div>
@endsection
