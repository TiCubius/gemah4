@extends('web._includes._master')

@section('content')
    <div class="row">

        @component("web._includes.components.title", ["back" => "web.statistiques.index"])
            Statistiques générales
        @endcomponent
        <div class="col-12">
            <form class="mb-3">
                <div class="card mb-3">
                    <div class="card-header gemah-bg-primary">
                        Recherche :
                        <a data-toggle="collapse" href="#option_recherche" aria-expanded="true"
                           aria-controls="option_recherche" id="recherche">
                            <i class="fa fa-chevron-down pull-right">...</i>
                        </a>
                    </div>

                    <div id="option_recherche" class="collapse show" aria-labelledby="recherche">
                        <div class="card-body row">
                            <div class="col-6">
                                @component("web._includes.components.departement", ["academies" => $academies, "id" => app("request")->input("departement_id")])
                                @endcomponent
                            </div>

                            <div class="col-6">
                                @component("web._includes.components.types_eleves",["types" => $types, "id" => app("request")->input("type_eleve_id")])
                                @endcomponent
                            </div>

                            <div class="form-group col-6">
                                <label class="optional" for="eleve_id">Identifiant</label>
                                <input id="eleve_id" class="form-control" name="eleve_id" type="text"
                                       placeholder="Ex: 200"
                                       value="{{ app("request")->input("eleve_id") }}">
                            </div>

                            <div class="form-group col-6">
                                <label class="optional" for="nom">Nom</label>
                                <input id="nom" class="form-control" name="nom" type="text" placeholder="Ex: SMITH"
                                       value="{{ app("request")->input("nom") }}">
                            </div>

                            <div class="form-group col-6">
                                <label class="optional" for="prenom">Prénom</label>
                                <input id="prenom" class="form-control" name="prenom" type="text" placeholder="Ex: John"
                                       value="{{ app("request")->input("prenom") }}">
                            </div>

                            <div class="form-group col-6">
                                <label class="optional" for="date_naissance">Date de naisance</label>
                                <input id="date_naissance" class="form-control" name="date_naissance" type="date"
                                       placeholder="Ex: 01/01/2019"
                                       value="{{ app("request")->input("date_naissance") }}">
                            </div>

                            <div class="form-group col-6">
                                <label class="optional" for="code_ine">Code INE</label>
                                <input id="code_ine" class="form-control" name="code_ine" type="text"
                                       placeholder="Ex: 0000000000X"
                                       value="{{ app("request")->input("code_ine") }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header gemah-bg-primary">
                        Filtres :
                        <a data-toggle="collapse" href="#option_filtre" aria-expanded="true"
                           aria-controls="option_filtre" id="filtre">
                            <i class="fa fa-chevron-down pull-right">...</i>
                        </a>
                    </div>
                    <div id="option_filtre" class="collapse show" aria-labelledby="filtre">
                        <div class="card-body row">
                            {{-- Gérer avec le controller --}}
                            <div class="col-6">
                                @component("web._includes.components.filtre", [
                                "optional"      => "on",
                                "filter"        => "etablissement",
                                "filter_name"   => "Attribués à un établissement :",
                                "first_option"  => "Uniquement avec",
                                "second_option" => "Uniquement sans"])
                                @endcomponent
                            </div>

                            {{-- Tri par possesions de matériel --}}
                            <div class="col-6">
                                @component("web._includes.components.filtre", [
                                "optional"      => "on",
                                "filter"        => "materiel",
                                "filter_name"   => "Possédants du matériels :",
                                "first_option"  => "Uniquement avec",
                                "second_option" => "Uniquement sans"])
                                @endcomponent
                            </div>

                            {{-- Tri par possesions de responsable --}}
                            <div class="col-6">
                                @component("web._includes.components.filtre", [
                                "optional"      => "on",
                                "filter"        => "responsable",
                                "filter_name"   => "Liés à des responsables :",
                                "first_option"  => "Uniquement avec",
                                "second_option" => "Uniquement sans"])
                                @endcomponent
                            </div>

                            {{-- Tri par possesions de document --}}
                            <div class="col-6">
                                @component("web._includes.components.filtre", [
                                "optional"      => "on",
                                "filter"        => "document",
                                "filter_name"   => "Possédants des documents :",
                                "first_option"  => "Uniquement avec",
                                "second_option" => "Uniquement sans"])
                                @endcomponent
                            </div>


                            {{-- Tri par dernière création élève --}}
                            <div class="col-6">
                                @component("web._includes.components.filtre", [
                                "optional"      => "on",
                                "filter"        => "creation_eleve",
                                "filter_name"   => "Ordre des dernières créations d'élèves :",
                                "first_option"  => "Croissant",
                                "second_option" => "Décroissant"])
                                @endcomponent
                            </div>

                            {{-- Tri par dernière modification élève --}}
                            <div class="col-6">
                                @component("web._includes.components.filtre", [
                                "optional"      => "on",
                                "filter"        => "modification_eleve",
                                "filter_name"   => "Ordre des dernières modifications d'élèves :",
                                "first_option"  => "Croissant",
                                "second_option" => "Décroissant"])
                                @endcomponent
                            </div>


                            {{-- Tri par dernière modification document/décision --}}
                            <div class="col-6">
                                @component("web._includes.components.filtre", [
                                "optional"      => "on",
                                "filter"        => "creation_document",
                                "filter_name"   => "Ordre des dernières modifications de documents :",
                                "first_option"  => "Croissant",
                                "second_option" => "Décroissant"])
                                @endcomponent
                            </div>

                            {{-- Tri par dernière modification document/décision --}}
                            <div class="col-6">
                                @component("web._includes.components.filtre", [
                                "optional"      => "on",
                                "filter"        => "modification_document",
                                "filter_name"   => "Ordre des dernières modifications de document :",
                                "first_option"  => "Croissant",
                                "second_option" => "Décroissant"])
                                @endcomponent
                            </div>

                            {{-- Tri par dernier ticket --}}
                            <div class="col-6">
                                @component("web._includes.components.filtre", [
                                "optional"      => "on",
                                "filter"        => "creation_ticket",
                                "filter_name"   => "Ordre des dernières créations de tickets :",
                                "first_option"  => "Croissant",
                                "second_option" => "Décroissant"])
                                @endcomponent
                            </div>

                            {{-- Tri par dernier ticket --}}
                            <div class="col-6">
                                @component("web._includes.components.filtre", [
                                "optional"      => "on",
                                "filter"        => "modification_ticket",
                                "filter_name"   => "Ordre des dernières modifications de tickets :",
                                "first_option"  => "Croissant",
                                "second_option" => "Décroissant"])
                                @endcomponent
                            </div>


                            {{-- Nom par ordre alphabétique --}}
                            <div class="col-6">
                                @component("web._includes.components.filtre", [
                                "optional"      => "on",
                                "filter"        => "alphabetique_nom",
                                "filter_name"   => "Ordre alphabétique par nom :",
                                "first_option"  => "A-Z",
                                "second_option" => "Z-A"])
                                @endcomponent
                            </div>

                            {{-- Prénom par ordre alphabétique --}}
                            <div class="col-6">
                                @component("web._includes.components.filtre", [
                                "optional"      => "on",
                                "filter"        => "alphabetique_prenom",
                                "filter_name"   => "Ordre alphabétique par prénom :",
                                "first_option"  => "A-Z",
                                "second_option" => "Z-A"])
                                @endcomponent
                            </div>

                            {{-- Date de naissance (croissant/décroissant --}}
                            <div class="col-6">
                                @component("web._includes.components.filtre", [
                                "optional"      => "on",
                                "filter"        => "ordre_naissance",
                                "filter_name"   => "Tri par dates de naissances :",
                                "first_option"  => "Croissante",
                                "second_option" => "Décroissante"])
                                @endcomponent
                            </div>


                        </div>
                    </div>
                </div>

                <button class="btn btn-outline-dark float-right mb-3">Rechercher</button>
            </form>

            <div class="table-responsive">
                <table class="table table-hover text-center">
                    <thead class="gemah-bg-primary">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Date de naissance</th>
                        <th>Action</th>
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
                                    <td>
                                        <a href="{{ route("web.scolarites.eleves.show", [$eleve]) }}">
                                            <button class="btn btn-outline-primary">
                                                Détails
                                            </button>
                                        </a>
                                    </td>
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