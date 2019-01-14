@extends('web._includes._master')

@include('web._includes.sidebars.eleve')
@section('content')

    @component("web._includes.components.title", ["back" => "web.scolarites.eleves.documents.index", "id" => [$eleve]])
        Édition de {{ $decision->document->nom }}
    @endcomponent

    <!-- enctype="multipart/form-data" permet l'envoie de fichiers -->
    <form action="{{ route('web.scolarites.eleves.documents.decisions.update', [$eleve, $decision]) }}"
          method="POST"
          enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}

        <div class="row">
            <div class="col-6">
                <div>
                    <div class="form-group">
                        <label for="date_cda">Date de la CDA</label>
                        <input type="date" id="date_cda" name="date_cda" placeholder="Date de la CDA"
                               class="form-control"
                               value="{{ $decision->date_cda ? $decision->date_cda->format('Y-m-d') : '' }}">
                    </div>
                </div>

                <div>
                    <div class="form-group">
                        <label for="date_notif">Date de réception de la notification</label>
                        <input type="date" id="date_notif" name="date_notif"
                               placeholder="Date de réception de la notification" class="form-control"
                               value="{{ $decision->date_notif ? $decision->date_notif->format('Y-m-d') : '' }}">
                    </div>
                </div>

                <div>
                    <div class="form-group">
                        <label for="date_limite">Date limite de la décision</label>
                        <input type="date" id="date_limite" name="date_limite" placeholder="Date limite de la décision"
                               class="form-control"
                               value="{{ $decision->date_limite ? $decision->date_limite->format('Y-m-d') : '' }}">
                    </div>
                </div>

                <div>
                    <div class="form-group">
                        <label for="date_convention">Date de la convention</label>
                        <input type="date" id="date_lidate_conventionmite" name="date_convention"
                               placeholder="Date de la convention" class="form-control"
                               value="{{ $decision->date_convention ? $decision->date_convention->format('Y-m-d') : '' }}">
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div>
                    <div class="form-group">
                        <label for="numero_dossier">Numéro du dossier MDPH</label>
                        <input type="text" id="numero_dossier" name="numero_dossier"
                               placeholder="Numéro du dossier Mdph"
                               class="form-control" value="{{ $decision->numero_dossier ?? '' }}">
                    </div>
                </div>

                <div>
                    <div class="form-group">
                        <label for="enseignant_id">Nom/prénom de l'enseignant référent</label>
                        <select name="enseignant_id" id="enseignant_id" class="form-control">
                            <option value="">Choisissez l'Enseignant Référent</option>
                            @foreach ($enseignants as $enseignant)
                                @if ($enseignant->id === $decision->enseignant_id)
                                    <option selected
                                            value="{{ $enseignant->id }}">{{ $enseignant->nom }} {{ $enseignant->prenom }}</option>
                                @else
                                    <option value="{{ $enseignant->id }}">{{ $enseignant->nom }} {{ $enseignant->prenom }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <div class="form-group">
                        <label for="nom_suivi">Affaire suivie par</label>
                        <input type="text" id="nom_suivi" name="nom_suivi" placeholder="Affaire suivie par"
                               class="form-control" value="{{ $decision->nom_suivi ?? '' }}">
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <label for="file">Fichier</label>
                <div class="form-group">
                    <div class="custom-file">
                        <input id="file" name="file" type="file" class="custom-file-input">
                        <label class="custom-file-label" for="file">Choisissez un fichier</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal" data-target="#modal">
                Supprimer la décision
            </button>
            <button class="btn btn-sm btn-outline-primary">Modifier la décision</button>
        </div>
    </form>


    @component("web._includes.components.modals.destroy", ["route" => "web.scolarites.eleves.documents.decisions.destroy", "id" => [$eleve, $decision]])
        @slot("name")
            {{ $decision->document->nom }}
        @endslot
    @endcomponent
@endsection