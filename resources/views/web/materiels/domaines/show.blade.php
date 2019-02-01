@extends('web._includes._master')
@section('content')
    <div class="row">

        @component("web._includes.components.title", ["back" => "web.materiels.domaines.index"])
            Profil du domaine matériel "{{ $domaine->libelle }}"

            @slot("custom")
                <div class="btn-group">
                    <div class="btn btn-outline-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Gestion domaine matériel
                    </div>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                        @hasPermission("materiels/domaines/edit")
                        <a class="dropdown-item" href="{{ route("web.materiels.domaines.edit", [$domaine]) }}">Éditer le domaine matériel</a>
                        @endHas
                    </div>
                </div>
            @endslot
        @endcomponent


        @component("web._includes.components.show_card", ["title" => "Types de matériel", "id" => "type"])
            <table id="types" class="table" width="100%">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($domaine->types as $type)
                    <tr>
                        <td>{{ $type->libelle }}</td>
                        <td>
                            @hasPermission("materiels/types/show")
                            <a href="{{ route("web.materiels.types.show", [$type]) }}">
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
            $('#types').DataTable({
                "language": {
                    "url": "{{ asset("assets/js/dataTables.french.json") }}"
                },
                "info": false,
                "columnDefs": [
                    {"orderable": false, "targets": 1},
                ],
                "pageLength": 10,
                "fnInitComplete": function () {
                    $("#types").show()
                },
            })
        })
    </script>
@endsection