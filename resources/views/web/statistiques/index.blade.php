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

			@hasPermission("statistiques/totaliteExport")
			<a id="submit" class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary" data-toggle="modal" data-target="#total" href="#">
				Exporter toute la base de donnée
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

	@component("web._includes.components.modals.base", ["route" => "web.statistiques.totalite.exports", "tab"=> true, "modalId" => "total", "method" => "GET"])
		@slot("title")
			Exportation de la base de donnée
		@endslot

		L'exportation totale de la base de donnée peut prendre plusieur minute

	@endcomponent
@endsection