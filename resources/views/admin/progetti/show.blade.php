@extends('layouts.admin')

@section('page-title', $progetto->title)
@section('content')
    <h1>{{ $progetto->title }}</h1>
    <p>{{ $progetto->content }}</p>

    <small>{{ $progetto->slug }}</small>
    <h3>Tipo:{{ $progetto->type ? $progetto->type->name : 'Nessun tipo abbinato' }}</h3>
    <div class="mt-5">
        <a class="btn btn-primary" href="{{ route('admin.progetti.index') }}">Torna alla lista</a>


    </div>

    @if ($progetto->cover_image)
        <img class="img-thumbnail" src="{{ asset('storage/' . $progetto->cover_image) }}" alt="{{ $progetto->title }}" />
    @endif

@endsection
