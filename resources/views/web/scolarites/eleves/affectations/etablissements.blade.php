@extends("web._includes._master")
@section("content")

    <div class="row">
        @component("web._includes.components.title", ["back" => "web.scolarites.eleves.show", "id" => [$eleve]])
            Affectation d'un établissement
        @endcomponent


        <div class="col-12 mb-3">
            <form class="card">
                <div class="card-header gemah-bg-primary">Rechercher un établissement</div>

                <div class="card-body">
                    @component("web._includes.components.departement", ["academies" => $academies, "id" => app("request")->input("departement_id")])
                    @endcomponent

                    @component("web._includes.components.types_etablissements", ["types" => $types, "id" => app("request")->input("type_etablissement_id")])
                    @endcomponent

                    <div class="form-group">
                        <label class="optional" for="nom">Nom</label>
                        <input id="nom" class="form-control" name="nom" type="text" placeholder="Ex: Lycée Simone Weil"
                               value="{{ app("request")->input("nom") }}">
                    </div>

                    <div class="form-group">
                        <label class="optional" for="ville">Ville</label>
                        <input id="ville" class="form-control" name="ville" type="text" placeholder="Ex: Saint-Etienne"
                               value="{{ app("request")->input("ville") }}">
                    </div>

                    <div class="form-group">
                        <label class="optional" for="telephone">N° de Téléphone</label>
                        <input id="telephone" class="form-control" name="telephone" type="text"
                               placeholder="Ex: 04 77 92 12 62" value="{{ app("request")->input("telephone") }}">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route("web.scolarites.eleves.affectations.etablissements.index", [$eleve]) }}">
                            <button class="btn btn-outline-dark" type="button">Annuler la recherche</button>
                        </a>

                        <button class="btn btn-outline-dark">Rechercher</button>
                    </div>
                </div>
            </form>
        </div>

        @isset($searchedEtablissements)
            <div class="col-12 mb-3">
                @if($searchedEtablissements->isEmpty())
                    <div class="alert alert-warning">
                        Aucun établissement n'a été trouvé avec ces critères
                    </div>
                @else
                    <table class="table table-sm table-hover text-center">
                        <thead class="gemah-bg-primary">
                        <tr>
                            <th>Nom</th>
                            <th>Ville</th>
                            <th>Téléphone</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($searchedEtablissements as $etablissement)
                            <tr>
                                <th>{{ "{$etablissement->nom} {$etablissement->prenom}" }}</th>
                                <td>{{ $etablissement->ville }}</td>
                                <td>{{ $etablissement->telephone }}</td>
                                <td>
                                    <form action="{{ route("web.scolarites.eleves.affectations.etablissements.attach", [$eleve, $etablissement]) }}"
                                          method="POST">
                                        {{ csrf_field() }}

                                        <button class="btn btn-sm btn-outline-primary">Affecter</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        @endisset
    </div>

@endsection

@include("web._includes.sidebars.eleve")