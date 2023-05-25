@extends('layouts.admin')

@section('page-title', 'Elenco de tipi')



@section('content')
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Titolo</th>
                <th scope="col">Slug</th>
                <th scope="col">Categoria</th>
                <th scope="col">Azioni</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($types as $type)
                <tr>
                    <td>{{ $type->id }}</td>
                    <td>{{ $type->name }}</td>
                    <td>{{ $type->slug }}</td>
                    <td>{{ count($type->progetti) }}</td>
                    <td>



                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
