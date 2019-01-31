@extends('web._includes._master')
@section('content')
    <div class="row">

        @component("web._includes.components.title", ["back" => "web.administrations.regions.index"])
            Profil de la région "{{ $region->nom }}"
        @endcomponent


        @component("web._includes.components.show_card", ["title" => "Académies", "id" => "academie"])
            <table id="academies" class="table" width="100%">
                <thead>
                <tr>
                    <td><strong>Nom</strong></td>
                    <td><strong>Action</strong></td>
                </tr>
                </thead>
                <tbody>
                @foreach($region->academies as $academie)
                    <tr>
                        <td>{{ $academie->nom }}</td>
                        <td>
                            @hasPermission("administrations/academies/show")
                            <a href="{{ route("web.administrations.academies.show", [$academie]) }}"
                               class="btn btn-outline-primary" type="btn">
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
            $('#academies').DataTable({
                "info": false,
                "columnDefs": [
                    {"orderable": false, "targets": 1},
                ],
                "pageLength": 10,
                "fnInitComplete": function () {
                    $("#academies").show()
                },
            })
        })
    </script>
@endsection