@extends('web._includes._master')
@section('content')
    <div class="row">

        @component("web._includes.components.title", ["back" => "web.administrations.departements.index"])
            Profil du responsable "{{ $responsable->nom }} {{ $responsable->prenom }}"
        @endcomponent

            @component("web._includes.components.show_card", ["title" => "Eleves", "id" => "eleve"])
                <table id="eleves" class="table" width="100%">
                    <thead>
                    <tr class="align-middle">
                        <th class="align-middle"><strong>Nom</strong></th>
                        <th class="align-middle"><strong>Prénom</strong></th>
                        <th class="align-middle"><strong>Date de naissance</strong></th>
                        <th class="align-middle" width="116px"><strong>Actions</strong></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($responsable->eleves as $eleve)
                        <tr>
                            <td>{{ $eleve->nom }}</td>
                            <td>{{ $eleve->prenom }}</td>
                            <td>{{ \Carbon\Carbon::parse($eleve->date_naissance)->format("d/m/Y") }}</td>
                            <td>
                                @hasPermission("eleves/show")
                                <a href="{{ route("web.scolarites.eleves.show", [$eleve]) }}"
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
    {{-- Eleves --}}
    <script>
        $(document).ready(function () {
            $('#eleves').DataTable({
                "info": false,
                "columnDefs": [
                    {"orderable": false, "targets": 1},
                ],
                "pageLength": 10,
                "fnInitComplete": function () {
                    $("#eleves").show()
                },
            })
        })
    </script>
@endsection