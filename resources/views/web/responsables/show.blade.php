@extends('web._includes._master')
@section('content')
    <div class="row">

        @component("web._includes.components.title", ["back" => "web.administrations.departements.index"])
            Profil du responsable "{{ $responsable->nom }} {{ $responsable->prenom }}"
        @endcomponent

        <div class="col-12 mb-3">
            <div class="card w-100">
                <div class="card-header gemah-bg-primary d-flex align-items-center justify-content-between">
                    Responsable
                </div>

                <div class="card-body">
                    <strong>Nom</strong>: {{ $responsable->nom }} <br>
                    <strong>Prénom</strong>: {{ $responsable->prenom }} <br>
                    <strong>Adresse</strong>: {{ $responsable->adresse }} <br>
                    <strong>Ville</strong>: {{ $responsable->ville }} <br>
                    <strong>Téléphone</strong>: {{ $responsable->telephone }} <br>
                    <strong>Email</strong>: {{ $responsable->email }} <br>
                </div>
            </div>
        </div>

        @foreach($responsable->eleves as $eleve)
            <div class="col-md-6 mb-3">
                <div class="card w-100">
                    <div class="card-header gemah-bg-primary d-flex justify-content-between align-items-center">
                        Elève
                        <div>
                            @foreach($eleve->types as $type)
                                <div class="badge badge-success m-0">{{ $type->libelle }}</div>
                            @endforeach
                                @hasPermission("eleves/show")
                                <a href="{{ route("web.scolarites.eleves.show", [$eleve]) }}">
                                    <button class="btn btn-sm btn-outline-warning">
                                        <i class="fas fa-info-circle"></i>
                                        Détails
                                    </button>
                                </a>
                                @endHas
                        </div>
                    </div>

                    <div class="card-body">
                        <strong>Nom</strong>: {{ $eleve->nom }} <br>
                        <strong>Prénom</strong>: {{ $eleve->prenom }} <br>
                        <strong>Date de naissance</strong>: {{ $eleve->date_naissance->format("d/m/Y") }} <br>
                        <strong>Joker</strong>: {{ $eleve->joker }} <br>
                        <strong>Information sur le matériel</strong>
                        @if(count($eleve->materiels) >= 1)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Marque</th>
                                        <th>Modèle</th>
                                        <th>Prêt le</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($eleve->materiels as $materiel)
                                        <tr>
                                            <td>{{ $materiel->type->libelle }}</td>
                                            <td>{{ $materiel->marque }}</td>
                                            <td>{{ $materiel->modele }}</td>
                                            <td>{{ Carbon\Carbon::parse($materiel->updated_at)->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <div data-toggle="tooltip" data-placement="bottom"
                             title="Le prix global correspond au prix de tout les matériels qui ont été affectés et désaffectés de cet élève">
                            <strong>Prix global</strong> : {{ $eleve->prix_global }} €
                        </div>

                        <div>
                            <strong>Prix actuel</strong> : {{ $eleve->materiels->sum('prix_ttc') }} €
                        </div>
                    </div>
                    @elseif($eleve->prix_global > 0)
                </div>
                <div class="card-footer">
                    <strong>Aucun matériel assigné</strong>
                </div>

                <div class="card-footer" data-toggle="tooltip" data-placement="bottom"
                     title="Le prix global correspond au prix de tout les matériels qui ont été affectés et désaffectés de cet élève">
                    <strong>Prix global</strong>: {{ $eleve->prix_global }} €
                </div>
            </div>
    </div>
    @endif
    </div>
    </div>
    @endforeach


@endsection
@section("scripts")
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection