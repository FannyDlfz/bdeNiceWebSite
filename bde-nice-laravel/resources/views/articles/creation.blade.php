@extends('template')


@section('content')

    <div id="main">
        <div class="orange_bar">
            <p id="inside_bar" style="margin:30px;">Création d'un Article</p>
        </div>
    </div>

    <form class="full-width-form" method="POST" action="/articles" enctype='multipart/form-data'>
        {{ csrf_field() }}<br/>
        {!! $errors->first('name', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-name">Nom</label>
            <input id="form-name" class="form-control" type="text" name="name" required/>
        </div>
        {!! $errors->first('price', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-price">Prix</label>
            <input id="form-price" class="form-control" type="number" name="price" required/>
        </div>
        {!! $errors->first('description', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-description">Description</label>
            <input id="form-description" class="form-control" type="text" name="description" required/>
        </div>
        {!! $errors->first('categories', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-categories">Categories</label>
            <select class="form-control" id="form-categories" name="categories[]" required multiple>

                @foreach($articleCategories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach

            </select>
        </div>
        {!! $errors->first('picture', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-picture">Photo</label>
            <input id="form-picture" class="form-control" type="file" name="picture" required/>
        </div>
        {!! $errors->first('picture_name', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-picture_name">Picture Name</label>
            <input id="form-picture_name" class="form-control" type="text" name="picture_name"/>
        </div>
        <br/>
        <input class="btn btn-lg btn-filled" type="submit" value="Valider"/>
        <a href="{{ route('articles.index') }}"><button type="button" class="btn btn-lg btn-danger">Retour aux articles</button></a>
    </form>

@endsection

@section('scripts')

    <script src="{{ asset('/js/animations.js') }}"></script>

@endsection
