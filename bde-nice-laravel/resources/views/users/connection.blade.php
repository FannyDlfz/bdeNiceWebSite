@extends('template')

@section('content')

    <div id="main">
        <div class="orange_bar">
            <p id="inside_bar" style="margin:30px;">Connexion</p>
        </div>
    </div>

    <form class="full-width-form" method="POST" action="/users/connect">
        {{ csrf_field() }}<br/>
        {!! $errors->first('email', '<p class="alert alert-danger">:message</p>') !!}<br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-email">Email</label>
            <input id="form-email" class="form-control" type="email" name="email"/>
        </div>
        <br/>
        {!! $errors->first('password', '<p class="alert alert-danger">:message</p>') !!}<br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-password">Password</label>
            <input id="form-password" class="form-control" type="password" name="password"/><br/>
        </div>
        <br/>
        <input class="btn btn-lg btn-filled" type="submit" value="Se connecter"/>
        <a href="{{ route('home') }}" class="btn btn-lg btn-danger">Revenir à l'accueil</a>
    </form>

@endsection
