@extends('template')

@section('content')
    <div id="main">
        <div class="orange_bar">
            <p id="inside_bar" style="margin:30px;">Modification d'un Article</p>
        </div>
    </div>
    <form class="full-width-form" method="POST" action="/articles/{{ $article->id }}" enctype='multipart/form-data'>
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <br/>
        {!! $errors->first('name', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-name">Nom</label>
            <input id="form-name" class="form-control" type="text" name="name" value="{{$article->name}}" required/>
        </div>
        {!! $errors->first('price', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-price">Prix</label>
            <input id="form-price" class="form-control" type="number" name="price" value="{{$article->price}}" required/>
        </div>
        {!! $errors->first('description', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-description">Description</label>
            <textarea id="form-description" class="form-control" type="text" name="description">{{ $article->description }}</textarea>
        </div>
        {!! $errors->first('categories', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-categories">Categories</label>
            <select class="form-control" id="form-categories" name="categories" multiple>

                @foreach($articleCategories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach

            </select>
        </div>
        {!! $errors->first('picture', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-picture">Photo</label>
            <input id="form-picture" class="form-control" type="file" name="picture" value="{{ $article->picture[0] }}}"/>
        </div>
        {!! $errors->first('picture_name', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-picture_name">Picture Name</label>
            <input id="form-picture_name" class="form-control" type="text" name="picture_name" value="{{$article->picture_name}}"/>
        </div>
        <br/>
        <input class="btn btn-lg btn-filled" type="submit" value="Modifier"/>
        <a href="{{ route('articles.index') }}"><button type="button" class="btn btn-lg btn-danger">Retour à l'édition d'articles</button></a>


@endsection

@section('scripts')

            <script src="{{ asset('/js/animations.js') }}"></script>

@endsection




