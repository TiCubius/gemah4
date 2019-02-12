@extends("docs._includes._master")
@php($title = "Gestion des images")
@section("content")

	<div id="content">
		<div class="title">
			<h4>Liste des images</h4>
		</div>

		<div class="images">
			@hasPermission("documentations/images/create")
			<div id="dragdrop">
				<h4>Glissez-déposez une image ici</h4>
			</div>

			<form id="form" action="{{ route("images.store") }}" method="POST" enctype=multipart/form-data>
				@csrf

				<input type="file" name="file" hidden>
			</form>
			@endHas

			<div class="images-list">
				<table>
					<thead>
						<tr>
							<th>Image</th>
							<th>Lien</th>
							<th width="100px">Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($images as $image)
							<tr>
								<td><img src="storage/{{ $image->path }}" class="image"></td>
								<td>{{ asset("storage/{$image->path}") }}</td>
								<td>
									@hasPermission("documentations/images/destroy")
									<form action="{{ route("images.destroy", [$image]) }}" method="POST">
										@csrf
										@method("DELETE")

										<button>Supprimer</button>
									</form>
									@endHas
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>

			</div>
		</div>
	</div>

@endsection

@section("scripts")

	<script>

		let $dragdrop = $(`#dragdrop`)
		let $form = $(`#form`)

		// We need to prevent the default Browser's behaviour when dragging and dropping files
		$dragdrop.on(`drag dragstart dragend dragover dragenter dragleave drop`, (e) => {
			e.preventDefault()
			e.stopPropagation()
		})


		$dragdrop.on(`drop`, (e) => {
			e.preventDefault()

			let droppedFiles = e.originalEvent.dataTransfer.files

			$form.find(`input[type="file"]`).prop(`files`, droppedFiles)
			$form.submit()
		})

	</script>

	<script>

		$(`img`).on(`click`, (e) => {
			console.log(e.target.src)
		})

	</script>

@endsection
