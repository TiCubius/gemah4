@extends("web._includes._master")
@section('content')

    @component('web._includes.components.title', ["back" => "web.index"])
        Liste des conventions
    @endcomponent

    <form method="POST" action="{{ route("web.conventions.update", ["" => $eleves]) }}">
        {{ csrf_field() }}
        {{ method_field("PATCH") }}
        <div class="row">
        @foreach($eleves as $eleve)
                <div class="col-12 col-md-6 col-lg-3 mt-3">
                    <div class="card">
                        <div class="card-header gemah-bg-primary">
                            {{ $eleve->nom }} {{ $eleve->prenom }}
                        </div>
                        <div class="card-body">
                            @foreach($eleve->responsables as $responsable)
                                <div class="custom-control custom-checkbox">
                                    <input name="eleve-{{$eleve->id}}_responsable-{{ $responsable->id }}" id="eleve-{{$eleve->id}}_responsable-{{ $responsable->id }}" class="custom-control-input" type="checkbox"
                                            @if($responsable->pivot->etat_signature )
                                            checked
                                            @endif>
                                    <label class="custom-control-label" for="eleve-{{$eleve->id}}_responsable-{{ $responsable->id }}">
                                        {{ $responsable->nom }} {{ $responsable->prenom }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-menu btn-outline-primary float-right">Enregistrer</button>
    </form>

@endsection