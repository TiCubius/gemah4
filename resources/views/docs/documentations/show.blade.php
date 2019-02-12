@extends('docs._includes._master')
@section('content')

    <div id="content">
        <h2 class="title">{{ $documentation->libelle }}</h2>

        @markdown($documentation->contenu)
    </div>

@endsection
