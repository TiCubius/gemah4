@extends('web._includes._master')
@php($title = "Statistiques")

@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.index"])
			Statistiques
		@endcomponent

		<div class="col-12">
			@hasPermission("statistiques/eleves")
			<a class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary" href="{{ route("web.statistiques.eleves") }}">
				Statistiques élèves
			</a>
			@endHas

			@hasPermission("statistiques/materiels")
			<a class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary" href="{{ route("web.statistiques.materiels") }}">
				Statistiques matériels
			</a>
			@endHas


			@hasPermission("statistiques/decisions")
			<a class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary" data-toggle="modal" data-target="#modal" href="#">
				Élèves dont la décision est dépassée
			</a>
			@endHas
		</div>
	</div>

	@component("web._includes.components.modals.base", ["route" => "web.statistiques.decisions", "method" => "GET"])
		@slot("title")
			Décisions dépassées
		@endslot

		Veuillez choisir une date à partir de laquelle les décisions seront considérées comme dépassées. <br><br>

		<input class="form-control" name="date" type="date" value="{{ \Carbon\Carbon::now()->subMonth(6)->format("Y-m-d") }}">
	@endcomponent
@endsection