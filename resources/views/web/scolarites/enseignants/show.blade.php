@extends('web._includes._master')
@section('content')
    <div class="row">

        @component("web._includes.components.title", ["back" => "web.administrations.departements.index"])
            Profil de l'enseignant "{{ $enseignant->nom }} {{ $enseignant->prenom }}"
        @endcomponent

        @component("web._includes.components.show_card", ["title" => "Etablissements", "id" => "etablissement"])
            <table id="etablissements" class="table" width="100%">
                <thead>
                <tr>
                    <td><strong>Nom</strong></td>
                    <td><strong>Action</strong></td>
                </tr>
                </thead>
                <tbody>
                @foreach($enseignant->etablissements as $etablissement)
                    <tr>
                        <td>{{ $etablissement->nom }}</td>
                        <td>
                            @hasPermission("etablissements/show")
                            <a href="{{ route("web.scolarites.etablissements.show", [$etablissement]) }}"
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
    {{-- Etablissements --}}
    <script>
        $(document).ready(function () {
            $('#etablissements').DataTable({
                "info": false,
                "columnDefs": [
                    {"orderable": false, "targets": 1},
                ],
                "pageLength": 10,
                "fnInitComplete": function () {
                    $("#etablissements").show()
                },
            })
        })
    </script>
@endsection