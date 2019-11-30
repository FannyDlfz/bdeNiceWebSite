@extends('template')

@section('content')

    <div id="main">
        <div class="orange-bar">
            <p id="inside-bar" style="margin:30px;">Modifiez votre catégorie</p>
        </div>
    </div>

    <form class="full-width-form" method="POST" action="/articleCategories/{{ $articleCategory->id }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <br/>

        {!! $errors->first('name', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-name">Nom</label>
            <input id="form-name" class="form-control" type="text" name="name" value="{{$articleCategory->name}}" required/>
        </div>
        <br/>

        <input class="btn btn-lg btn-submit" type="submit" value="Valider"/>
        <a href=""><button type="button" class="btn btn-lg btn-danger">Retour à la catégorie {{ $articleCategory->name }}</button></a>

    </form>

@endsection
