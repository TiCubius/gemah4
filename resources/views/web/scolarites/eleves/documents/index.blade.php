@extends('web._includes._master')

@section('content')

    <div class="row">

        <div class="col-12">
            <div class="d-flex justify-content-between">
                <h4>Gestion des documents</h4>
                <a href="{{route("web.scolarites.eleves.documents.create",$eleve)}}">
                    <button class="btn btn-sm btn-outline-primary">
                        Ajouter un Document
                    </button>
                </a>
            </div>

            <hr>
        </div>
    </div>

    <div class="row">
        @if ($eleve->documents->isEmpty())
            <div class="col-12">
                <div class="alert alert-warning">
                    Aucun document n'a été trouvé pour cet élève
                </div>
            </div>
        @else
           {{--@foreach ($eleve->decisions as $Decision)
                <div class="col-6 js-document-mdph">
                    <div class="card mb-3">
                        <div class="card-body">
                            <p class="mb-0">
                                <b>Réunion CDA</b>:
                                {!! $Decision->date_cda ?? '<span class="text-muted">Non défini</span>' !!}
                            </p>
                            <p class="mb-0">
                                <b>Réception de la Notification</b>:
                                {!! $Decision->date_notif ?? '<span class="text-muted">Non défini</span>' !!}
                            </p>
                            <p class="mb-0">
                                <b>Date Limite de la Décision</b>:
                                {!! $Decision->date_limite ?? '<span class="text-muted">Non défini</span>' !!}
                            </p>
                            <p class="mb-0">
                                <b>Date Convention</b>:
                                {!! $Decision->date_convention ?? '<span class="text-muted">Non défini</span>' !!}
                            </p>
                            <hr>
                            <p class="mb-0">
                                <b>Numéro MDPH</b>:
                                {!! $Decision->numero_dossier ?? '<span class="text-muted">Non défini</span>' !!}
                            </p>
                            <p class="mb-0">
                                <b>Enseignant Référent</b>:
                                @if ($Decision->enseignant_id !== NULL)
                                    {{ $Decision->enseignant->nom }} {{ $Decision->enseignant->prenom }}
                                @else
                                    <span class="text-muted">Non défini</span>
                                @endif
                            </p>
                            <p class="mb-0">
                                <b>Suivi par</b>:
                                {!! $Decision->nom_suivi ?? '<span class="text-muted">Non défini</span>' !!}
                            </p>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <a class="btn btn-sm btn-outline-secondary" href="{{ route('gemah.scolarites.eleves.decisions.edit', [$eleve->id, $Decision->id]) }}">
                                <i class="far fa-edit"></i>
                                Modifier
                            </a>
                            @if($Decision->document_id)
                                <div class="btn-group">
                                    <a class="btn btn-sm btn-outline-success" target="_blank" href="{{ route('gemah.scolarites.eleves.documents.download', [$eleve->id, $Decision->document_id]) }}">
                                        <i class="fas fa-download"></i>
                                        Télécharger
                                    </a>
                                    <a class="btn btn-sm btn-outline-success" target="_blank" href="{{ asset('storage/' . $Decision->document_id) }}">
                                        <i class="far fa-eye"></i>
                                        Visualiser
                                    </a>
                                </div>
                            @else
                                <div class="btn-group" data-toggle="tooltip" data-placement="top" title="Aucun fichier n'a été envoyé lors de la création de la décision">
                                    <a class="btn btn-sm btn-outline-danger" href="#">
                                        <i class="far fa-question-circle"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach--}}
            {{debug($eleve->documents)}}

        @foreach ($eleve->documents as $document)
                @if ($document->typeDocument->nom !== "Décision")
                    <div class="col-6 js-document-other">
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
                                <a class="btn btn-sm btn-outline-warning" href="{{ route('web.scolarites.eleves.documents.edit', [$eleve->id, $document->id]) }}">
                                    <i class="far fa-edit"></i>
                                    Modifier
                                </a>
                                @if($document->path)
                                    <div class="btn-group">
                                        <a class="btn btn-sm btn-primary" target="_blank" href="">
                                            <i class="fas fa-download"></i>
                                            Télécharger
                                        </a>
                                        <a class="btn btn-sm btn-primary" target="_blank" href="{{ asset('storage/documents/' . $document->path) }}">
                                            <i class="far fa-eye"></i>
                                            Visualiser
                                        </a>
                                    </div>
                                @else
                                    <div class="btn-group" data-toggle="tooltip" data-placement="top" title="Aucun fichier n'a été envoyé lors de la création du document">
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
        @endif
    </div>

@endsection

@section('js')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection