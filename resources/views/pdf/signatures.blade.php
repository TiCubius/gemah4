<html>
    <head>
        <meta charset="UTF-8">
        @include("pdf._includes.style")
    </head>

    <body>
    <section class="content" style="margin-top: 125px;">
        <h2>{{ $titre }}</h2>

        <section style="margin-top: 50px;">
            <table>
                <thead>
                <tr>
                    <th>Responsables</th>
                    <th>Elèves</th>
                </tr>
                </thead>
                <tbody>
                @foreach($responsables as $responsable)
                    @foreach($responsable->eleves as $eleve)
                        @if($eleve->pivot->etat_signature == $etat)
                            <tr>
                            <td>{{ $responsable->nom }} {{ $responsable->prenom }}</td>
                            <td>{{ $eleve->nom }} {{ $eleve->prenom }}</td>
                        </tr>
                        @endif
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </section>
    </section>
    </body>
</html>