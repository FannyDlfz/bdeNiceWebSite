@extends('template')


@section('content')

    <div id="main">
        <div class="orange_bar">
            <p id="inside_bar" style="margin:30px;">Création d'une photo d'évènement</p>
        </div>
    </div>

    <form class="full-width-form" method="POST" action="{{ route('eventPhotos.store') }}" enctype='multipart/form-data'>
        {{ csrf_field() }}<br/>
        <input type="hidden" value="{{ $event_id }}" name="event_id"/>
        {!! $errors->first('name', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-name">Nom</label>
            <input id="form-name" class="form-control" type="text" name="name" required/>
        </div>
        {!! $errors->first('description', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-description">Description</label>
            <input id="form-description" class="form-control" type="text" name="description" required/>
        </div>
        {!! $errors->first('picture', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-picture">Photo</label>
            <input id="form-picture" class="form-control" type="file" name="picture" required/>
        </div>
        <br/>
        <input class="btn btn-lg btn-filled" type="submit" value="Valider"/>
        <a href="{{ route('articles.index') }}"><button type="button" class="btn btn-lg btn-danger">Retour aux articles</button></a>
    </form>

@endsection

