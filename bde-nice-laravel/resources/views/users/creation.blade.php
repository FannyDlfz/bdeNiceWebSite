@extends('template')

@section('content')

    <div id="main">
        <div class="orange_bar">
            <p id="inside_bar" style="margin:30px;">Inscription</p>
        </div>
    </div>

    <form class="full-width-form" method="POST" action="/users">
        {{ csrf_field() }}<br/>
        {!! $errors->first('name', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-name">Nom</label>
            <input id="form-name" class="form-control" type="text" name="name"/>
        </div>
        {!! $errors->first('email', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-email">Email</label>
            <input id="form-email" class="form-control" type="email" name="email"/>
        </div>
        {!! $errors->first('password', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-password">Mot de passe</label>
            <input id="form-password" class="form-control" type="password" name="password"/>
        </div>
        {!! $errors->first('password_confirmed', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-confirm">Confirmation</label>
            <input id="form-confirm" class="form-control" type="password" name="password_confirmation"/>
        </div>
        {!! $errors->first('center', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-center">Centre CESI</label>
            <select class="form-control" id="form-center" name="center">

                @foreach($centers as $center)

                    <option value="{{ $center->id }}">{{ $center->name }}</option>

                @endforeach

            </select>
        </div>
        <p><input type="checkbox" required name="terms"> J'accepte les <a href="/legalMention">conditions d'utilisation</a> </p>
        <br/>
        <br/>
        <input class="btn btn-lg btn-filled" type="submit" value="S'inscrire"/>
        <a href="{{ route('home') }}" class="btn btn-lg btn-danger">Revenir à l'accueil</a>
    </form>

@endsection
