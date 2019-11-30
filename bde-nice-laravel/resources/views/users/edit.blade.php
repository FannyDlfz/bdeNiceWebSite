@extends('template')

@section('content')

    <div id="main">
        <div class="orange_bar">
            <p id="inside_bar" style="margin:30px;">Modifier le profil</p>
        </div>
    </div>

    <form class="full-width-form" method="POST" action="/users/{{ $user->id }}">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        {!! $errors->first('name', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-name">Nom</label>
            <input id="form-name" class="form-control" type="text" name="name" value="{{ $user->name }}"/>
        </div>
        {!! $errors->first('center', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-center">Centre CESI</label>
            <select class="form-control" id="form-center" name="center">

                @foreach($centers as $center)

                    <option value="{{ $center->id }}" selected="{{ ($user->center->{'_id'} == $center->id ? 'selected' : 'none') }}">{{ $center->name }}</option>

                @endforeach

            </select>
        </div>
        <br/>
        <input class="btn btn-lg btn-filled" type="submit" value="S'inscrire"/>
        <a href="{{ route('home') }}"><button type="button" class="btn btn-lg btn-danger">Revenir à l'accueil</button></a>
    </form>

@endsection
