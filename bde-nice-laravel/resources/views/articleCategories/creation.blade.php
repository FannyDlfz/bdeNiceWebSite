@extends('template')

@section('content')

    <div id="main">
        <div class="orange-bar">
            <p id="inside-bar" style="margin:30px;">Créez votre propre catégorie</p>
        </div>
    </div>

    <form class="full-width-form" method="POST" action="{{ route('articleCategories.store') }}" enctype="multipart/form-data">
        {{csrf_field()}}

        {!! $errors->first('name', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-name">Nom</label>
            <input id="form-name" class="form-control" type="text" name="name" required/>
        </div>
        <input class="btn btn-lg btn-submit" type="submit" value="Valider"/>
        <a href=""><button type="button" class="btn btn-lg btn-danger">Retour aux Catégories</button></a>
    </form>

@endsection
