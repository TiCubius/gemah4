@extends('web._includes._master')
@section('content')
    <div class="row">
        @component("web._includes.components.title", ["back" => "web.administrations.index"])
            Historique
        @endcomponent

        <table class="table table-sm table-hover text-center">
            <thead class="gemah-bg-primary">
                <tr>
                    <td>Type</td>
                    <td>Contenue</td>
                    <td>Date</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                @foreach($historiques as $historique)
                    <tr>
                        <td>{{ $historique->type }}</td>
                        <td>{{ $historique->contenue }}</td>
                        <td>{{ \Carbon\Carbon::make($historique->created_at)->format("d/m/Y") }}</td>
                        <td>
                            <a type="btn" class="btn btn-outline-primary" target="_blank" href="{{ route("web.administrations.historiques.show", [$historique]) }}">
                                <i class="fas fa-info-circle"></i>
                                Détails
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
    </div>
@endsection