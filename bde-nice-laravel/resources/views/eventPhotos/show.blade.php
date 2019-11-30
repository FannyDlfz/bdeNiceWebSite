@extends('template')

@section('content')

    <div class="picture-container">

        <img src="{{ $eventPhoto->name }}" class="picture-picture">
        <section class="picture-section">
            <h2 class="picture-title">Posté par {{ $user->name }} , <br>le {{ $eventPhoto->created_at }}</h2>
            <p class="picture-text">{{ $eventPhoto->description }}</p>
            <div class="like4">
                <i class="far fa-thumbs-up fa-3x"></i>
            </div>
        </section>

    </div>

    <div class="event-article-box">

        @include('comment.creation', ['eventPhoto' => $eventPhoto, 'attribute_name' => 'event_photo_id', 'attribute_id' => $eventPhoto->id])

        @php($i = 0)

        @foreach($comments as $comment)

            @php($i++);

            <section class="event-article-commentary">
                <h3 class="{{ 'event-article-commentary-title-' . ($i%2 == 0 ? 'right' : 'left') }}">{{ $comment->user()->name }}</h3>
                <section class="{{ 'event-article-commentary-text-' . ($i%2 == 0 ? 'right' : 'left') }}">
                    <p class="comment-flex-area">{{ $comment->text }}</p>
                </section>
                <div class="like">
                    <i class="far fa-thumbs-up fa-3x"></i>
                </div>
            </section>

        @endforeach

    </div>

@endsection
