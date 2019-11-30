@extends('template')

@section('content')

    <h3>{{ $user->name }}</h3>
    <p>{{ $user->email }}</p>
    <ul>
        <li>Centre: {{ $user->center->{'_name'} }}</li>
        <li>Role: {{ $user->role->{'_name'} }}</li>
    </ul>

    <a href="/users" type="button">En savoir moins</a>

    @if(session()->has('user'))
        @if(session('user') == $user->id)

            <a href="/users/{{ $user->id }}/edit" type="button">Modifier</a><br/>
            <form method="POST" action="/users/{{ $user->id }}">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <input type="submit" value="Supprimer de l'espace intersidéral"/>
            </form>

        @endif
    @endif

@endsection
