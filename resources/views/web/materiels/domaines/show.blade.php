@extends('web._includes._master')
@section('content')
    <div class="row">

        @component("web._includes.components.title", ["back" => "web.materiels.domaines.index"])
            Profil du domaine matériel "{{ $domaine->libelle }}"
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