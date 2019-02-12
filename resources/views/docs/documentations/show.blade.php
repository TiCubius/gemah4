@extends('docs._includes._master')
@php($title = $documentation->libelle)
@section('content')

    <div id="content">
        <h2 class="title">{{ $documentation->libelle }}</h2>

        <div class="markdown-body">
            @markdown($documentation->contenu)
        </div>
    </div>

@endsection
