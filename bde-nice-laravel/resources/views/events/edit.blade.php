@extends('template')

@section('content')

    <div id="main">
        <div class="orange_bar">
            <h3 id="inside_bar" style="margin:30px;">Modifiez votre évènement</h3>
        </div>
    </div>

    <form class="full-width-form" method="POST" action="/events/{{ $event->id }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('PATCH') }}
        <br/>

        {!! $errors->first('name', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-name">Nom</label>
            <input id="form-name" class="form-control" type="text" name="name" value="{{$event->name}}" required/>
        </div>
        <br/>

        {!! $errors->first('recurrence', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-recurrence">Recurrence</label>
            <input id="form-recurrence" class="form-control" type="text" name="recurrence" value="{{$event->recurrence}}" required/>
        </div>

        {!! $errors->first('price', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-price">Price</label>
            <input id="form-price" class="form-control" type="number" name="price" value="{{$event->price}}" required/>
        </div>

        {!! $errors->first('description', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-description">Description</label>
            <textarea id="form-description" class="form-control" name="description" required>{{ $event->description }}</textarea>
        </div>

        {!! $errors->first('categories', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-categories">Categories</label>
            <select class="form-control" id="form-categories" name="categories[]" multiple required>

                @foreach($eventCategories as $category)

                        <option value="{{$category->id}}" selected>{{$category->name}}</option>

                @endforeach

            </select>
        </div>

        {!! $errors->first('picture', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-picture">Image</label>
            <input id="form-picture" class="form-control" type="file" name="picture" value="{{$event->picture}}"/>
        </div>

        {!! $errors->first('picture_name', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-picture-name">Nom de l'image</label>
            <input id="form-picture-name" class="form-control" type="text" name="picture_name" value="{{$event->picture_name}}"/>
        </div>

        {!! $errors->first('begin_at', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-begDate">Date de début</label>
            <input id="form-begDate" class="form-control" type="date" name="begin_at" value="{{$event->begin_at}}" required/>
        </div>

        {!! $errors->first('end_at', '<p class="alert alert-danger">:message</p>') !!}
        <br/>
        <div class="input-group">
            <label class="input-group-addon" for="form-endDate">Date de fin</label>
            <input id="form-endDate" class="form-control" type="date" name="end_at" value="{{$event->end_at}}" required/>
        </div>
        <br/>
        <input class="btn btn-lg btn-filled" type="submit" value="Valider"/>
        <a href="{{ route('events.index') }}"><button type="button" class="btn btn-lg btn-danger">Retour aux évènements</button></a>

    </form>

@endsection
