@extends('template')

@section('content')

    <div class="top-shop">
        <img src="{{ $article->pictures[0]->name }}" alt="{{ $article->pictures[0]->name }}" class="img-shop">
        <div>
            <h1 class="title-shop">{{ $article->name }}</h1>
            <p class="text-shop">{{ $article->description }}</p>
            <div class="div-button-shop">

                @if(session()->has('user'))

                    <form method="POST" action="{{ route('basket.update', session('user')) }}">
                        {{csrf_field()}}
                        {{ method_field('PUT') }}

                        <input type="hidden" name="article_id" value="{{ $article->id }}"/>

                @endif

                    <button type="submit" class="fas fa-shopping-basket fa-2x">{{ $article->price }} €</button>

                @if(session()->has('user'))

                    </form>

                @endif
                <a class="button-shop" href="{{route('articles.index')}}">Retour à la liste</a>
            </div>
        </div>
    </div>
    <section class="footer-shop"></section>
    <div class="event-article-box">

        @include('comment.creation', ['article' => $article, 'attribute_name' => 'article_id', 'attribute_id' => $article->id])

        @php($i = 0)

        @foreach($comments as $comment)

            @php($i++);

            <section class="event-article-commentary">
                <h2 class="{{ 'event-article-commentary-title-' . ($i%2 == 0 ? 'right' : 'left') }}">{{ $comment->user()->name }}</h2>
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
