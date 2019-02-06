@if(env("APP_ENV") === "local")
	<div class="navbar_message d-flex">
		VERSION DE DÉVELOPPEMENT: Aucune modification ne sera sauvegardée

		<div class="ml-3">
			<a href="{{ env("APP_URL") }}:1080"> Serveur mail</a>
		</div>
	</div>
@endif

<nav class="navbar navbar-expand-xl navbar-dark gemah-bg-primary mb-3">
	<a class="navbar-brand" href="{{ route('web.index') }}">GEMAH</a>

	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="navbar-collapse w-100 order-3 collapse" id="navbar">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item active">
				<a class="nav-link" href="{{ route('web.index') }}">
					<i class="fas fa-home"></i> Accueil
				</a>
			</li>
			<li class="nav-item active">
				<a class="nav-link" href="{{ route("web.logout") }}">
					<i class="fas fa-sign-out-alt"></i> Déconnexion
				</a>
			</li>
		</ul>

		@yield("navbar")
	</div>

</nav>