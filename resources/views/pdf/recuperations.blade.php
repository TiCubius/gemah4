<html>
<head>
    <title>Récupération - {{ "{$eleve->nom} {$eleve->prenom}" }}</title>
    <meta charset="UTF-8">
    @include("pdf._includes.style")
</head>
<body>
<header>
    <section id="marianne" class="text-center">
        <img src="{{ resource_path("images/marianne-logo.png") }}" style="height: 75px;">
    </section>

			<section id="dsden" style="position: absolute; top: 0;">
				<img src="{{ resource_path("images/".session('user')->departement_id."/dsden-logo.png") }}">
			</section>
		</header>

<section class="content" style="margin-top: 125px;">
    <h2>Récépissé de récupération du matériel prêté</h2>

    <section id="date" style="margin-top: 50px;">
        A Saint-Etienne, le {{ \Carbon\Carbon::now()->format("d/m/Y") }}
    </section>

    <section style="margin-top: 50px;">
        Le responsable légal de {{ "{$eleve->nom} {$eleve->prenom}" }} nous a rendu le matériel suivant : <br><br>

        <table>
            <thead>
            <tr>
                <th>Type</th>
                <th>Marque</th>
                <th>N° de Série / Produit</th>
            </tr>
            </thead>
            <tbody>
            @foreach($eleve->materiels as $materiel)
                <tr>
                    <td>{{ $materiel->type->libelle }}</td>
                    <td>{{ $materiel->marque }}</td>
                    <td>
                        @if(!empty($materiel->cle_produit))
                            {{ $materiel->cle_produit }}
                        @else
                            {{ $materiel->numero_serie }}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>

    <section style="margin-top: 50px;">
        Nous en accusons et considérons que cette restitution est définitive
    </section>

    <section id="signature1" style="margin-top: 20px; height: 150px;">
        <div style="width: 50%; height: 150px; text-align: center; float: left;">
            Signature du responsable légal
        </div>
        <div style="width: 50%; height: 150px; text-align: center; float: left;">
            Signature de la DSDEN
        </div>
    </section>
</section>
</body>
</html>