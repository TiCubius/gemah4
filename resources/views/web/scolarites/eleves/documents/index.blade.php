@extends('web._includes._master')

@section('content')

    <div class="row">
        @component("web._includes.components.title", ["back" => "web.scolarites.eleves.index", "id" => [$eleve]])
            <div class="d-flex justify-content-between">
                <h4>Gestion des documents</h4>
            </div>
            @slot("custom")
                <div class="btn-group">

                    <div class="btn btn-outline-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                         data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ajouter un document
                    </div>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item"
                           href="{{route('web.scolarites.eleves.documents.decisions.create', [$eleve]) }}">
                            Décision
                        </a>
                        <a class="dropdown-item"
                           href="{{ route('web.scolarites.eleves.documents.create', [$eleve]) }}">
                            Autre document
                        </a>
                    </div>
                </div>
            @endslot
        @endcomponent

    </div>


    @if ($eleve->documents->isEmpty() && $eleve->decisions->isEmpty())
        <div class="col-12">
            <div class="alert alert-warning">
                Aucun document n'a été trouvé pour cet élève
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="type">Type de Document</label>
                    <select name="type" id="type" class="form-control" required>
                            <option selected value="" hidden>Choisissez un Type de Document</option>
                        @foreach($typesDocument as $typeDocument)
                            <option value="{{ $typeDocument->id }}">{{ $typeDocument->nom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @foreach ($eleve->decisions as $decision)
                <div class="col-6 js-document js-document-{{ $decision->document->type_document_id }}" style="display: none;">
                    <div class="card mb-3">
                        <div class="card-body">
                            <p class="mb-0">
                                <b>Réunion CDA</b>:
                                {!! $decision->date_cda ? $decision->date_cda->format("d/m/Y") : '<span class="text-muted">Non défini</span>' !!}
                            </p>
                            <p class="mb-0">
                                <b>Réception de la Notification</b>:
                                {!! $decision->date_notif ? $decision->date_notif->format("d/m/Y") : '<span class="text-muted">Non défini</span>' !!}
                            </p>
                            <p class="mb-0">
                                <b>Date Limite de la Décision</b>:
                                {!! $decision->date_limite ? $decision->date_limite->format("d/m/Y") : '<span class="text-muted">Non défini</span>' !!}
                            </p>
                            <p class="mb-0">
                                <b>Date Convention</b>:
                                {!! $decision->date_convention ? $decision->date_convention->format("d/m/Y") : '<span class="text-muted">Non défini</span>' !!}
                            </p>
                            <hr>
                            <p class="mb-0">
                                <b>Numéro MDPH</b>:
                                {!! $decision->numero_dossier ?? '<span class="text-muted">Non défini</span>' !!}
                            </p>
                            <p class="mb-0">
                                <b>Enseignant Référent</b>:
                                @if ($decision->enseignant_id !== NULL)
                                    {{ $decision->enseignant->nom }} {{ $decision->enseignant->prenom }}
                                @else
                                    <span class="text-muted">Non défini</span>
                                @endif
                            </p>
                            <p class="mb-0">
                                <b>Suivi par</b>:
                                {!! $decision->nom_suivi ?? '<span class="text-muted">Non défini</span>' !!}
                            </p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('web.scolarites.eleves.documents.decisions.edit', [$eleve, $decision]) }}">
                                <i class="far fa-edit"></i>
                                Modifier
                            </a>
                            @if($decision->document_id)
                                <div class="btn-group">
                                    <a class="btn btn-sm btn-outline-success" target="_blank" href="{{ route("web.scolarites.eleves.documents.decisions.download", [$eleve, $decision]) }}">
                                        <i class="fas fa-download"></i>
                                        Télécharger
                                    </a>
                                    <a class="btn btn-sm btn-outline-success" target="_blank"
                                       href="{{ asset('storage/decisions/' . $decision->document->path) }}">
                                        <i class="far fa-eye"></i>
                                        Visualiser
                                    </a>
                                </div>
                            @else
                                <div class="btn-group" data-toggle="tooltip" data-placement="top"
                                     title="Aucun fichier n'a été envoyé lors de la création de la décision">
                                    <a class="btn btn-sm btn-outline-danger" href="#">
                                        <i class="far fa-question-circle"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            @foreach ($eleve->documents as $document)
                @if ($document->typeDocument->nom !== "Décision")
                    <div class="col-6 js-document js-document-{{ $document->type_document_id }}" style="display: none;">
                        <div class="card mb-3">
                            <div class="card-body">
                                <p class="mb-0">
                                    <b>Nom</b>:
                                    {!! $document->nom ?? '<span class="text-muted">Non défini</span>' !!}
                                </p>
                                <p>
                                    <b>Description</b>:
                                    {!! $document->description ?? '<span class="text-muted">Non défini</span>' !!}
                                </p>
                                <p class="mb-0">Document soumis le {{ $document->created_at }}</p>
                            </div>
                            <div class="card-footer gemah-bg-primary d-flex justify-content-between">
                                <a class="btn btn-sm btn-outline-warning"
                                   href="{{ route('web.scolarites.eleves.documents.edit', [$eleve->id, $document->id]) }}">
                                    <i class="far fa-edit"></i>
                                    Modifier
                                </a>
                                @if($document->path)
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-primary" target="_blank" href="{{ route("web.scolarites.eleves.documents.download", [$eleve, $document]) }}">
                                            <i class="fas fa-download"></i>
                                            Télécharger
                                        </a>
                                        <a class="btn btn-sm btn-primary"
                                           href="{{ asset('storage/documents/' . $document->path) }}">
                                            <i class="far fa-eye"></i>
                                            Visualiser
                                        </a>
                                    </div>
                                @else
                                    <div class="btn-group" data-toggle="tooltip" data-placement="top"
                                         title="Aucun fichier n'a été envoyé lors de la création du document">
                                        <a class="btn btn-sm btn-outline-danger" href="#">
                                            <i class="far fa-question-circle"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif

@endsection

@include("web._includes.sidebars.eleve")

@section('scripts')
    <script>

        $('#type').on('change', () => {

            let type = $("#type")

            $(`.js-document`).hide()
            $(`.js-document-${type.val()}`).show()

        }).trigger("change")

    </script>
@endsection