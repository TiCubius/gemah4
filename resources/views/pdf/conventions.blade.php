<html lang="fr">
<head>
    <title>Consignes d'utilisation du materiel</title>
    <meta charset="UTF-8">
    @include("pdf._includes.style")
</head>

@foreach($eleves as $eleve)
    @php
        $decision = $eleve->decisions->sortBy("created_at")->last()
    @endphp

    @foreach($eleve->responsables as $responsable)
        <body style="font-size: 14px;">
        <header>
            <section id="marianne" class="text-center">
                <img src="{{ resource_path("images/marianne-logo.png") }}" style="height: 75px;">
            </section>

					<section id="dsden" style="position: relative; margin-top: -75px">
						<img src="{{ resource_path("images/".$departement->id."/dsden-logo.png") }}">
					</section>

					<section id="responsable" style="margin-top: 50px; margin-left: 58%;">
						<p>
							L’Inspecteur d’académie, directeur académique <br> {{ $parametres["conventions/direction/localisation"] }}
							<br> <br> à <br><br>
							{{ "{$responsable->nom} {$responsable->prenom}" }} <br>
							{{ "{$responsable->adresse}" }} <br>
							{{ "{$responsable->code_postal} {$responsable->ville}" }}
						</p>
					</section>

            <section id="informations" style="width: 125px; font-size: 10px; text-align: right; margin-top: -150px;">
                <p>
                    CONVENTIONS <br> Affaire suivie par : <br>
                    {{ $parametres["conventions/affaire/convention/nom"] }} <br>
                    {{ $parametres["conventions/affaire/convention/telephone"] }} <br>
                    {{ $parametres["conventions/affaire/convention/email"] }} <br>
                </p>

                <p>
                    MATERIEL INFORMATIQUE <br> Affaire suivie par : <br>
                    {{ $parametres["conventions/affaire/informatique/nom"] }} <br>
                    {{ $parametres["conventions/affaire/informatique/telephone"] }} <br>
                    {{ $parametres["conventions/affaire/informatique/email"] }} <br>
                </p>

                <p>
                    MATERIEL AUDIO <br> Affaire suivie par : <br>
                    {{ $parametres["conventions/affaire/audio/nom"] }} <br>
                    {{ $parametres["conventions/affaire/audio/telephone"] }} <br>
                    {{ $parametres["conventions/affaire/audio/email"] }} <br>
                </p>

                <p>
                    ADRESSE <br>
                    {{ $parametres["conventions/adresse"] }} <br>
                    {{ $parametres["conventions/code_postal"] }} {{ $parametres["conventions/ville"] }}
                </p>
            </section>
        </header>

				<section id="content">
					<section id="lois" style="text-align: justify;">
						<p>
							<i>
								{{ $parametres["conventions/lois/entete"] }}
							</i>
						</p>
					</section>

					<section id="parties">
						<p>
							Entre les soussignés : <br><br>
							D'une part le directeur académique {{ $parametres["conventions/direction/localisation"] }} <br><br>
							Et, d'autre part : {{"{$responsable->nom} {$responsable->prenom}"}}<br><br>
							Représentant légal de l'élève (articles L 131-4 du Code de l'Education)
						</p>


                <div style="display: inline-block; width: 50%; float: left; text-align: left;">
                    <p>
                        Élève <br> Nom / Prénom : <b>{{ "{$eleve->nom} {$eleve->prenom}" }}</b> <br> Né(e) le :
                        <b>{{ "{$eleve->date_naissance->format('d/m/Y')}" }}</b>
                    </p>
                </div>

                <div style="display: inline-block; width: 50%; float: left; text-align: left;">
                    @if( request("etablissement") == "true" )
                        <p>
                            Scolarisé(e) à <br> Etablissement : <b>{{ "{$eleve->etablissement->nom}" }}</b> <br> Classe
                            : <b>{{ "{$eleve->classe}" }}</b> <br>
                        </p>
                    @else
                        <p>
                            Scolarisé(e) à <br>
                            Etablissement :<br>
                            Classe : </p>
                    @endif
                </div>

                <p>Il a été convenu ce qui suit :</p>
            </section>

					<section id="article-1" style="margin-top: 50px; text-align: justify;">
						<h2>{{ $parametres["conventions/article1/titre"] }}</h2>

						<p>
							{!! $parametres["conventions/article1/contenu"] !!}
						</p>
					</section>

					<div class="new-page"></div>
					<section id="article2" style="text-align: justify;">
						<h2>{{ $parametres["conventions/article2/titre"] }}</h2>
						<p>
							Pour <b>l'année scolaire {{ $parametres["conventions/annee"] }}</b> est mis à disposition le matériel suivant appartenant à l’Etat :
						</p>

                <table>
                    <thead>
                    <tr>
                        <th>Type</th>
                        <th>Marque</th>
                        <th>Modèle</th>
                        <th>N° de Série</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($eleve->materiels as $materiel)
                        <tr>
                            <td>{{ $materiel->type->libelle }}</td>
                            <td>{{ $materiel->marque }}</td>
                            <td>{{ $materiel->modele }}</td>
                            @if($materiel->type->domaine->libelle == "Logiciel")
                                <td>{{ $materiel->cle_produit }}</td>
                            @else
                                <td>{{ $materiel->numero_serie }}</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </section>


					<section id="article3" style="text-align: justify;">
						<h2>{{ $parametres["conventions/article3/titre"] }}</h2>

						<p>
							{!! $parametres["conventions/article3/contenu"] !!}
						</p>
					</section>

					<section id="article4" style="text-align: justify;">
						<h2></h2>

						<p>
							{!! $parametres["conventions/article4/contenu"] !!}
						</p>
					</section>

					<section id="article5" style="text-align: justify;">
						<h2>{{ $parametres["conventions/article5/titre"] }}</h2>

						<p>
							{!! $parametres["conventions/article5/contenu"] !!}

							@if($decision->date_limite)
								Le prêt de matériel prendra fin le {{ $decision->date_limite->format("d/m/Y") }} en vertu de la
								décision du {{ $decision->date_notification ? $decision->date_notification->format("d/m/Y") : \Carbon\Carbon::now()->format("d/m/Y") }}.
							@endif
						</p>
					</section>

            <section id="signature1" style="margin-top: 20px; height: 150px;">
                <div style="width: 50%; height: 150px; text-align: center; float: left;">
                    <p>
                        {{ $parametres["conventions/signatures/lieu"] }}, <br> le : {{ \Carbon\Carbon::now()->format('d/m/Y') }} <br><br>

                        Le représentant légal </p>
                </div>

                <div style="width: 50%; height: 150px; text-align: center; float: left;">
                    <p>
                        {{ $parametres["conventions/signatures/lieu"] }} le {{ \Carbon\Carbon::now()->format('d/m/Y') }} <br><br>

								Pour l’inspecteur d’académie, directeur académique {{ $parametres["conventions/direction/localisation"] }} <br>
								Par délégation <br><br>
								Le secrétaire général <br>
								{{ $parametres["conventions/secretaire"] }}
							</p>
						</div>
					</section>

            <section>
                <p>Dans le cas d'un matériel restant en permanence sur le lieu de scolarisation : signature du Chef
                    d'établissement ou du représentant de la commune (articles 1921, 1927 et suivants du Code
                    civil). </p>
            </section>

            <section id="signature2" style="height: 50px;">
                <div style="float: left; width: 50%; text-align: center; height: 50px;">
                    {{ $parametres["conventions/signatures/lieu"] }} le : {{ \Carbon\Carbon::now()->format('d/m/Y') }}
                </div>

                <div style="float: left; width: 50%; text-align: center; height: 50px;">
                    Qualité du signataire
                </div>
            </section>

            <section class="text-center">
                <p><b>Cette convention, après signature de la famille et du secrétaire général, doit être conservée par
                        la famille</b></p>
            </section>
        </section>
        </body>
        @if(!$loop->last)
            <div class="new-page"></div>
        @endif
    @endforeach

    @if(!$loop->last)
        <div class="new-page"></div>
    @endif
@endforeach
</html>