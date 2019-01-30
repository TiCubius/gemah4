@extends('web._includes._master')
@section('content')
    <div class="row">

        @component("web._includes.components.title", ["back" => "web.index"])
            Statistiques
        @endcomponent

        <div class="col-12">
            @hasPermission("statistiques/generale")
            <a href="{{ route("web.statistiques.generale") }}">
                <button class="btn btn-menu btn-primary btn-lg w-100 mb-3 gemah-bg-primary">
                    Statistiques générales
                </button>
            </a>
            @endHas

        </div>
    </div>
@endsection