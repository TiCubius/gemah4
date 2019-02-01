@extends('web._includes._master')
@section('content')
    <div class="row">

        @component("web._includes.components.title", ["back" => "web.administrations.utilisateurs.index"])
            Profil de l'utilisateur "{{ $utilisateur->nom }} {{ $utilisateur->prenom }}"
        @endcomponent


        @component("web._includes.components.show_card", ["title" => "Historique", "id" => "historique"])
            <table id="historiques" class="table" width="100%">
                <thead>
                <tr>
                    <td>Type</td>
                    <td>Contenue</td>
                    <td>Date</td>
                    <td>Action</td>
                </tr>
                </thead>
                <tbody>
                @foreach($utilisateur->historiques as $historique)
                    <tr>
                        <td>{{ $historique->type }}</td>
                        <td>{{ $historique->contenue }}</td>
                        <td>{{ $historique->created_at->format("d/m/Y") }}</td>
                        <td>
                            @hasPermission("administrations/historiques/show")
                            <a type="btn" class="btn btn-outline-primary" target="_blank" href="{{ route("web.administrations.historiques.show", [$historique]) }}">
                                <i class="fas fa-info-circle"></i>
                                Détails
                            </a>
                            @endHas
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endcomponent
    </div>

@endsection
@section("scripts")
    {{-- Académies --}}
    <script>
        $(document).ready(function () {
            $('#historiques').DataTable({
                "info": false,
                "columnDefs": [
                    {"orderable": false, "targets": 1},
                ],
                "pageLength": 10,
                "fnInitComplete": function () {
                    $("#historiques").show()
                },
            })
        })
    </script>
@endsection