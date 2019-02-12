<section id="sidebar">

	<input id="search" type="text" placeholder="Recherche">

	<div class="content">

		<a href="{{ route("web.index") }}">
			<h4>Retour à GEMAH</h4>
		</a>
		<a href="{{ route("documentations.index") }}">
			<h4>Retour à l'index </h4>
		</a>

		<div class="categories">
			<a href="{{ route("categories.index") }}">
				<h4>Catégories</h4>
			</a>

			@include("docs._includes.categories", ["categories" => $categories])
		</div>

		@isLoggedIn
		<a href="{{ route("images.index") }}">
			<h4>Gestion des images</h4>
		</a>
		@endIsLoggedIn

		@yield("sidebar")
	</div>
</section>

@section("scripts")
	<script>
		let categories = document.querySelectorAll(`.categorie`)
		let $search = document.querySelector(`#search`)

		categories.forEach((categorie) => {
			// On affiche les orphelins
			if (categorie.dataset.categorieParent === "") {
				categorie.classList.add(`show`)
			}

			categorie.addEventListener(`click`, (e) => {
				e.stopPropagation()

				// On affiche les enfants
				Array.from(categorie.children).forEach((child) => {
					child.classList.toggle(`show`)
				})
			})
		})

		$search.addEventListener(`keyup`, () => {
			let value = $search.value

			setTimeout(() => {
				if (value === $search.value) {
					if (value === "") {

						// Remise à zéro de la recherche
						categories.forEach((categorie) => {
							categorie.classList.add(`show`)
							if (categorie.dataset.categorieParent !== "") {
								categorie.classList.remove(`show`)
							}
						})

					} else {
						for (let i = 1; i <= categories.length; i++) {
							let categorie = categories[i - 1]

							// On cache toutes les catégories
							categorie.classList.remove(`show`)

							if (categorie.innerHTML.toLowerCase().includes(value.toLowerCase())) {
								// On affiche la catégorie
								categorie.classList.add(`show`)

								let parent = categorie.parentNode
								while (parent.classList.contains(`categorie`)) {
									parent = parent.parentNode
									categorie.parentNode.classList.add(`show`)
								}
							}
						}
					}
				}
			}, 250)
		})
	</script>
@endsection
