@extends('web._includes._master')
@section('content')
	<div class="row">

		@component("web._includes.components.title", ["back" => "web.index"])
			Statistiques
		@endcomponent

        <div class="col-12">
            <a href="{{ route("web.statistiques.eleves") }}">
                <button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
                    Liste élèves
                </button>
            </a>
            <a href="{{ route("web.statistiques.materiels") }}">
                <button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
                    Liste matériels
                </button>
            </a>
            <a href="{{ route("web.statistiques.decisions") }}">
                <button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
                    Liste élèves de date décision depassé
                </button>
            </a>

		</div>
	</div>
@endsection