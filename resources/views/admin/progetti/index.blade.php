@extends('layouts.admin')



@section('content')
    <a href="{{ route('admin.progetti.create') }}" class="btn btn-primary">Crea nuovo post</a>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Titolo</th>
                <th scope="col">Slug</th>
                <th scope="col">Categoria</th>
                <th scope="col">Tecnologies</th>
                <th scope="col">Azioni</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($progetti as $progetto)
                <tr>
                    <td>{{ $progetto->id }}</td>
                    <td>{{ $progetto->title }}</td>
                    <td>{{ $progetto->slug }}</td>
                    <td>{{ $progetto->type ? $progetto->type->name : 'Nessun tipo abbinato' }}</td>
                    <td>
                        @foreach ($progetto->technologies as $technology)
                            {{ $technology->name }}
                        @endforeach

                    </td>
                    <td>
                        <a class="btn btn-primary" href="{{ route('admin.progetti.show', $progetto->slug) }}">VEDI</a>
                        <a class="btn btn-warning" href="{{ route('admin.progetti.edit', $progetto->slug) }}">MODIFICA</a>

                        <form class="form_delete_post"
                            action="{{ route('admin.progetti.destroy', ['progetto' => $progetto->slug]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Elimina</button>
                        </form>


                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
