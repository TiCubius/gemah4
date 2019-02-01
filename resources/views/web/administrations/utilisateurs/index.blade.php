@extends('web._includes._master')
@section('content')
    <div class="row">

        @component("web._includes.components.title", ["add" => "web.administrations.utilisateurs.create", "permission" => "administrations/utilisateurs/create", "back" => "web.administrations.index"])
            Gestion des utilisateurs
        @endcomponent

        <div class="col-12">
            @if($utilisateurs->isEmpty())
                <div class="alert alert-warning">
                    Aucun utilisateur n'est enregistré sur l'application
                </div>
            @else

                <div class="table-responsive">
                    <table id="table" class="table table-sm table-hover text-center" style="display: none;">
                        <thead class="gemah-bg-primary">
                        <tr>
                            <th>Service</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($utilisateurs as $utilisateur)
                            <tr>
                                <td>{{ $utilisateur->service->nom }}</td>
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
                                    @hasPermission("administrations/utilisateurs/create")
                                    <a href="{{ route("web.administrations.utilisateurs.edit", [$utilisateur]) }}">
                                        <button class="btn btn-sm btn-outline-primary">Editer</button>
                                    </a>
                                    @endHas
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
@endsection


@section("scripts")
    <script>
        $(document).ready(function () {
            $('#table').DataTable({
                "language": {
                    "url": "{{ asset("assets/js/dataTables.french.json") }}"
                },
                "info": false,
                "columnDefs": [
                    {"orderable": false, "targets": 3},
                ],
                "pageLength": 50,
                "fnInitComplete": function () {
                    $("#table").show()
                },
            })
        })
    </script>
@endsection