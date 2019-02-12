@extends('web._includes._master')
@php($title = "Gestion du matériel")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.index"])
			Gestion du matériel
		@endcomponent

		@hasPermission("materiels/stocks/index")
		<div class="col-12">
			<a href="{{ route("web.materiels.stocks.index") }}">
				<button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
					Gestion des stocks de matériel
				</button>
			</a>
		</div>
		@endHas


		@hasPermission("materiels/domaines/index")
		<div class="col-12">
			<a href="{{ route("web.materiels.domaines.index") }}">
				<button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
					Gestion des domaines matériel
				</button>
			</a>
		</div>
		@endHas


		@hasPermission("materiels/types/index")
		<div class="col-12">
			<a href="{{ route("web.materiels.types.index") }}">
				<button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
					Gestion des types matériel
				</button>
			</a>
		</div>
		@endHas
	</div>
@endsection
