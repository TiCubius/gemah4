<html>
	<head>
		<meta charset="UTF-8">
		@include("pdf._includes.style")
	</head>

	<body>
		<section class="content">
			<h2>{{ $titre }}</h2>

			<section>
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
								@if($eleve->pivot->etat_signature === $etatAttendu)
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