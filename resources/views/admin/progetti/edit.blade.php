@extends('layouts.admin')

@section('page-title', 'Modifica il post')

@section('content')

    <form method="POST" action="{{ route('admin.progetti.update', ['progetto' => $progetto->slug]) }}"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Titolo</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror " id="title" name="title"
                value="{{ old('title', $progetto->title) }}">
            @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="cover_image" class="form-label">Seleziona immagine</label>
            @if ($progetto->cover_image)
                <img class="img-thumbnail" src="{{ asset('storage/' . $progetto->cover_image) }}"
                    alt="{{ $progetto->title }}" />
            @endif
            <input type="file" class="form-control @error('cover_image') is-invalid @enderror " id="cover_image"
                name="cover_image">
            @error('cover_image')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="type_id" class="form-label">Seleziona il tipo</label>
            <select class="form-select @error('type_id') is-invalid @enderror" name="type_id" id="type_id">
                <option @selected(old('type_id', $progetto->type_id) == '') value="">Nessuna categoria</option>
                @foreach ($types as $type)
                    <option @selected(old('type_id', $progetto->type_id) == $type->id) value="{{ $type->id }}">{{ $type->name }}</option>
                @endforeach
            </select>
            @error('type_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Testo dell'articolo</label>
            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content">{{ old('content', $progetto->content) }}</textarea>
            @error('content')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            @foreach ($technologies as $technology)
                @if ($errors->any())
                    <input id="technology_{{ $technology->id }}" @if (in_array($technology->id, old('technologies', []))) checked @endif
                        type="checkbox" name="technology[]" value="{{ $technology->id }}">
                @else
                    <input id="technology_{{ $technology->id }}" @if ($progetto->technologies->contains($technology->id)) checked @endif
                        type="checkbox" name="technology[]" value="{{ $technology->id }}">
                @endif

                <label for="technology_{{ $technology->id }}" class="form-label">{{ $technology->name }}</label>
                <br>
            @endforeach
            @error('technologies')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror


        </div>


        <button type="submit" class="btn btn-primary">Salva</button>

    </form>

@endsection
