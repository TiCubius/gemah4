@extends('web._includes._master')

@section('content')
    <div class="row">

        @component("web._includes.components.title", ["back" => "web.statistiques.index"])
            Statistiques générales
        @endcomponent
        <div class="col-12">
            <form class="card mb-3">
                <div class="card-header gemah-bg-primary">
                    Rechercher
                </div>

                <div class="card-body">
                    @component("web._includes.components.departement", ["academies" => $academies, "id" => app("request")->input("departement_id")])
                    @endcomponent

                    @component("web._includes.components.types_eleves",["types" => $types, "id" => app("request")->input("type_eleve_id")])
                    @endcomponent

                    <div class="form-group">
                        <label class="optional" for="eleve_id">Identifiant</label>
                        <input id="eleve_id" class="form-control" name="eleve_id" type="text" placeholder="Ex: 200"
                               value="{{ app("request")->input("eleve_id") }}">
                    </div>

                    <div class="form-group">
                        <label class="optional" for="nom">Nom</label>
                        <input id="nom" class="form-control" name="nom" type="text" placeholder="Ex: SMITH"
                               value="{{ app("request")->input("nom") }}">
                    </div>

                    <div class="form-group">
                        <label class="optional" for="prenom">Prénom</label>
                        <input id="prenom" class="form-control" name="prenom" type="text" placeholder="Ex: John"
                               value="{{ app("request")->input("prenom") }}">
                    </div>

                    <div class="form-group">
                        <label class="optional" for="date_naissance">Date de naisance</label>
                        <input id="date_naissance" class="form-control" name="date_naissance" type="date"
                               placeholder="Ex: 01/01/2019" value="{{ app("request")->input("date_naissance") }}">
                    </div>

                    <div class="form-group">
                        <label class="optional" for="code_ine">Code INE</label>
                        <input id="code_ine" class="form-control" name="code_ine" type="text"
                               placeholder="Ex: 0000000000X"
                               value="{{ app("request")->input("prenom") }}">
                    </div>

                    <hr>
                    {{-- Gérer en JS (Plus tard) : --}}
                    {{-- Nom par ordre alphabétique --}}
                    <label for="alphabetique_nom">Ordre alphabétique par Nom :</label>
                    <select name="alphabetique_nom" class="form-control">
                        @if(app("request")->input("alphabetique_nom") == "normal")
                            <option>Sélectionner un filtre...</option>
                            <option selected value="normal">A-Z</option>
                            <option value="inverted">Z-A</option>
                        @elseif(app("request")->input("alphabetique_nom") == "inverted")
                            <option>Sélectionner un filtre...</option>
                            <option value="normal">A-Z</option>
                            <option selected value="inverted">Z-A</option>
                        @else
                            <option selected>Sélectionner un filtre...</option>
                            <option value="normal">A-Z</option>
                            <option value="inverted">Z-A</option>
                        @endif
                    </select>

                    {{-- Prénom par ordre alphabétique --}}
                    <label for="alphabetique_prenom">Ordre alphabétique par Prénom :</label>
                    <select name="alphabetique_prenom" class="form-control">
                        @if(app("request")->input("alphabetique_prenom") == "normal")
                            <option>Sélectionner un filtre...</option>
                            <option selected value="normal">A-Z</option>
                            <option value="inverted">Z-A</option>
                        @elseif(app("request")->input("alphabetique_prenom") == "inverted")
                            <option>Sélectionner un filtre...</option>
                            <option value="normal">A-Z</option>
                            <option selected value="inverted">Z-A</option>
                        @else
                            <option selected>Sélectionner un filtre...</option>
                            <option value="normal">A-Z</option>
                            <option value="inverted">Z-A</option>
                        @endif
                    </select>

                    {{-- Date de naissance (croissant/décroissant --}}
                    <label for="ordre_naissance">Ordre des dates de naissances :</label>
                    <select name="ordre_naissance" class="form-control">
                        @if(app("request")->input("alphabetique_prenom") == "normal")
                            <option>Sélectionner un filtre...</option>
                            <option selected value="normal">Croissant</option>
                            <option value="inverted">Décroissant</option>
                        @elseif(app("request")->input("alphabetique_prenom") == "inverted")
                            <option>Sélectionner un filtre...</option>
                            <option value="normal">Croissant</option>
                            <option selected value="inverted">Décroissant</option>
                        @else
                            <option selected>Sélectionner un filtre...</option>
                            <option value="normal">Croissant</option>
                            <option value="inverted">Décroissant</option>
                        @endif
                    </select>

                    {{-- Gérer avec le controller --}}
                    <label for="etablissement">Etablissement :</label>
                    <select name="etablissement" class="form-control">
                        @if(app("request")->input("etablissement") == "with")
                            <option>Sélectionner un filtre...</option>
                            <option selected value="with">Elèves lié</option>
                            <option value="without">Elèves non lié</option>
                        @elseif(app("request")->input("etablissement") == "without")
                            <option>Sélectionner un filtre...</option>
                            <option value="with">Elèves lié</option>
                            <option selected value="without">Elèves non lié</option>
                        @else
                            <option selected>Sélectionner un filtre...</option>
                            <option value="with">Elèves lié</option>
                            <option value="without">Elèves non lié</option>
                        @endif
                    </select>

                    <label for="materiel">Matériels :</label>
                    <select name="materiel" class="form-control">
                        @if(app("request")->input("materiel") == "with")
                            <option>Sélectionner un filtre...</option>
                            <option selected value="with">Elèves lié</option>
                            <option value="without">Elèves non lié</option>
                        @elseif(app("request")->input("materiel") == "without")
                            <option>Sélectionner un filtre...</option>
                            <option value="with">Elèves lié</option>
                            <option selected value="without">Elèves non lié</option>
                        @else
                            <option selected>Sélectionner un filtre...</option>
                            <option value="with">Elèves lié</option>
                            <option value="without">Elèves non lié</option>
                        @endif
                    </select>

                    <label for="responsable">Responsables :</label>
                    <select name="responsable" class="form-control">
                        @if(app("request")->input("responsable") == "with")
                            <option>Sélectionner un filtre...</option>
                            <option selected value="with">Elèves lié</option>
                            <option value="without">Elèves non lié</option>
                        @elseif(app("request")->input("responsable") == "without")
                            <option>Sélectionner un filtre...</option>
                            <option value="with">Elèves lié</option>
                            <option selected value="without">Elèves non lié</option>
                        @else
                            <option selected>Sélectionner un filtre...</option>
                            <option value="with">Elèves lié</option>
                            <option value="without">Elèves non lié</option>
                        @endif
                    </select>

                    <label for="document">Documents :</label>
                    <select name="document" class="form-control">
                        @if(app("request")->input("document") == "with")
                            <option>Sélectionner un filtre...</option>
                            <option selected value="with">Elèves lié</option>
                            <option value="without">Elèves non lié</option>
                        @elseif(app("request")->input("document") == "without")
                            <option>Sélectionner un filtre...</option>
                            <option value="with">Elèves lié</option>
                            <option selected value="without">Elèves non lié</option>
                        @else
                            <option selected>Sélectionner un filtre...</option>
                            <option value="with">Elèves lié</option>
                            <option value="without">Elèves non lié</option>
                        @endif
                    </select>

                    {{-- Dernière modification/création élève --}}
                    <label for="creation_eleve">Ordre de dernières créations de l'élève :</label>
                    <select name="creation_eleve" class="form-control">
                        @if(app("request")->input("alphabetique_prenom") == "normal")
                            <option>Sélectionner un filtre...</option>
                            <option selected value="normal">Croissant</option>
                            <option value="inverted">Décroissant</option>
                        @elseif(app("request")->input("alphabetique_prenom") == "inverted")
                            <option>Sélectionner un filtre...</option>
                            <option value="normal">Croissant</option>
                            <option selected value="inverted">Décroissant</option>
                        @else
                            <option selected>Sélectionner un filtre...</option>
                            <option value="normal">Croissant</option>
                            <option value="inverted">Décroissant</option>
                        @endif
                    </select>

                    <label for="modification_eleve">Ordre de dernières modifications de l'élève :</label>
                    <select name="modification_eleve" class="form-control">
                        @if(app("request")->input("alphabetique_prenom") == "normal")
                            <option>Sélectionner un filtre...</option>
                            <option selected value="normal">Croissant</option>
                            <option value="inverted">Décroissant</option>
                        @elseif(app("request")->input("alphabetique_prenom") == "inverted")
                            <option>Sélectionner un filtre...</option>
                            <option value="normal">Croissant</option>
                            <option selected value="inverted">Décroissant</option>
                        @else
                            <option selected>Sélectionner un filtre...</option>
                            <option value="normal">Croissant</option>
                            <option value="inverted">Décroissant</option>
                        @endif
                    </select>

                    {{-- Dernier document/décision --}}
                    <label for="document">Ordre de dernier ajout/modification d'un document :</label>
                    <select name="document" class="form-control">
                        @if(app("request")->input("alphabetique_prenom") == "normal")
                            <option>Sélectionner un filtre...</option>
                            <option selected value="normal">Croissant</option>
                            <option value="inverted">Décroissant</option>
                        @elseif(app("request")->input("alphabetique_prenom") == "inverted")
                            <option>Sélectionner un filtre...</option>
                            <option value="normal">Croissant</option>
                            <option selected value="inverted">Décroissant</option>
                        @else
                            <option selected>Sélectionner un filtre...</option>
                            <option value="normal">Croissant</option>
                            <option value="inverted">Décroissant</option>
                        @endif
                    </select>

                    {{-- Dernier ticket --}}
                    <label for="ticket">Ordre de dernier ticket :</label>
                    <select name="ticket" class="form-control">
                        @if(app("request")->input("alphabetique_prenom") == "normal")
                            <option>Sélectionner un filtre...</option>
                            <option selected value="normal">Croissant</option>
                            <option value="inverted">Décroissant</option>
                        @elseif(app("request")->input("alphabetique_prenom") == "inverted")
                            <option>Sélectionner un filtre...</option>
                            <option value="normal">Croissant</option>
                            <option selected value="inverted">Décroissant</option>
                        @else
                            <option selected>Sélectionner un filtre...</option>
                            <option value="normal">Croissant</option>
                            <option value="inverted">Décroissant</option>
                        @endif
                    </select>

                    <hr>
                    <button class="btn btn-outline-dark">Rechercher</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover text-center">
                    <thead class="gemah-bg-primary">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Date de naissance</th>
                    </tr>
                    </thead>

                    <tbody>
                    @isset($searchedEleves)
                        @if($searchedEleves)
                            @foreach($searchedEleves as $eleve)
                                <tr>
                                    <td>{{ $eleve->id }}</td>
                                    <td>{{ $eleve->nom }}</td>
                                    <td>{{ $eleve->prenom }}</td>
                                    <td>{{ \Carbon\Carbon::parse($eleve->date_naissance)->format("d/m/Y") }}</td>
                                </tr>
                            @endforeach
                        @endif
                    @else
                        @foreach($eleves as $eleve)
                            <tr>
                                <td>{{ $eleve->id }}</td>
                                <td>{{ $eleve->nom }}</td>
                                <td>{{ $eleve->prenom }}</td>
                                <td>{{ \Carbon\Carbon::parse($eleve->date_naissance)->format("d/m/Y") }}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection