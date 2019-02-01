@extends('web._includes._master')
@section('content')
    <div class="row">

        @component("web._includes.components.title", ["back" => "web.administrations.services.index"])
            Profil du service "{{ $service->nom }}"

            @slot("custom")
                <div class="btn-group">
                    <div class="btn btn-outline-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Gestion service
                    </div>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                        @hasPermission("administrations/services/edit")
                        <a class="dropdown-item" href="{{ route("web.administrations.services.edit", [$service]) }}">Éditer le service</a>
                        @endHas
                    </div>
                </div>
            @endslot
        @endcomponent


        @component("web._includes.components.show_card", ["title" => "Utilisateurs", "id" => "utilisateur"])
            <table id="utilisateurs" class="table" width="100%">
                <thead>
                <tr>
                    <td><strong>Nom</strong></td>
                    <th><strong>Email</strong></th>
                    <td><strong>Action</strong></td>
                </tr>
                </thead>
                <tbody>
                @foreach($service->utilisateurs as $utilisateur)
                    <tr>
                        <td>{{ "{$utilisateur->nom} {$utilisateur->prenom}" }}</td>
                        <td>{{ $utilisateur->email }}</td>
                        <td>
                            @hasPermission("administrations/utilisateurs/show")
                            <a href="{{ route("web.administrations.utilisateurs.show", [$utilisateur]) }}">
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-info-circle"></i>
                                    Détails
                                </button>
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
            $('#utilisateurs').DataTable({
                "language": {
                    "url": "{{ asset("assets/js/dataTables.french.json") }}"
                },
                "info": false,
                "columnDefs": [
                    {"orderable": false, "targets": 1},
                ],
                "pageLength": 10,
                "fnInitComplete": function () {
                    $("#utilisateurs").show()
                },
            })
        })
    </script>
@endsection