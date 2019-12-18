@extends('template')

@section('content')

    <div class="image-event-article" style="background-image: url('{{( preg_match('#^https?:\/\/.*#', $event->pictures[0]->name)
            ? $event->pictures[0]->name
            : asset('/event-photos/' . \App\Gestion\SlugGestion::slugify($event->pictures[0]->name) . '.' . $event->pictures[0]->extension) )}}');"
         xmlns="http://www.w3.org/1999/html">

        <section class="section-event-article">
            <h1 class="title-event-article">{{ $event->name }}</h1>
            <section class="text-event-article">{{ $event->description }}</section>
        </section>

        <section class="section-event-date">
            <h2 class="event-date-title">{{ $event->begin_at }} </h2>
            <section class="event-date-text">
                <div class="event-date-text-text">
                    <p><i class="fas fa-dollar-sign fa-3x"></i>{{$event->price}}</p>
                    <p><i class="fas fa-user-ninja fa-3x"></i>{{ count($subscriptions) }}
                        @if($event->scheduled)

                            @if(strtotime($event->begin_at) > time())
                                personne{{ count($subscriptions) > 1 ? 's' : '' }} y participe{{ count($subscriptions) > 1 ? 'nt' : '' }} déjà
                            @else
                                personne{{ count($subscriptions) > 1 ? 's' : '' }} y {{ count($subscriptions) > 1 ? 'ont' : 'a' }} participé
                            @endif

                        @endif
                    </p>
                </div>

                {{--@if($event->scheduled)--}}
                    @if(strtotime($event->begin_at) > time())

                        @if($userRole == 4 || $userRole == 2)
                            <a class="buttonevent-article" href="/events/{{ $event->id }}/subscribers">Accéder à la liste des inscrits</a>
                        @elseif(!$is_user_subscribed)
                            <a class="buttonevent-article" href="/events/{{ $event->id }}/subscribe">Participer</a>
                        @else
                            <a class="buttonevent-article" href="/events/{{ $event->id }}/unsubscribe">Ne plus participer</a>
                        @endif
                    @elseif($is_user_subscribed)
                        <a class="buttonevent-article" href="/events-photos/create/{{ $event->id }}">Poster un souvenir</a>
                    @endif

            </section>
        </section>

    </div>

    @if($event->scheduled && strtotime($event->begin_at) < time())
        <div role="main">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">

                <!-- Wrapper for slides -->
                <div class="carousel-inner">

                    @foreach($eventPhotos as $eventPhoto)

                        <section class="event-article-before-container">
                            <a href="{{route('eventPhotos.show', $eventPhoto->id)}}" class="event-article-link">
                                <img src="{{( preg_match('#^https?:\/\/.*#', $eventPhoto->name)
                                            ? $eventPhoto->name
                                            : asset('/event-photos-users/' . \App\Gestion\SlugGestion::slugify($eventPhoto->name) . '.' . $eventPhoto->extension) )}}"
                                     alt="{{ $eventPhoto->name }}" class="event-article-picture" />
                            </a>

                            <p class="event-article-post">Posté par {{ $event_photos_users[$eventPhoto->id]->name}}, le {{$eventPhoto->created_at}}</p>

                            <div class="like3">
                                <i class="far fa-thumbs-up fa-3x"></i>
                            </div>
                        </section>

                    @endforeach

                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="search-bar carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    @endif

    <div class="event-article-box">

    @include('comment.creation', ['event' => $event, 'attribute_name' => 'event_id', 'attribute_id' => $event->id])

    @php($i = 0)

    @foreach($comments as $comment)

        @php($i++)

        @if($userRole != 3)
        @if(!$comment->hidden)
        <section class="event-article-commentary">
            <h3 class="{{ 'event-article-commentary-title-' . ($i%2 == 0 ? 'right' : 'left') }}">{{ $comment->user()->name }} and {{$comment->hidden}}</h3>

            <section class="{{ 'event-article-commentary-text-' . ($i%2 == 0 ? 'right' : 'left') }}">
                <p class="comment-flex-area">{{ $comment->text }}</p>
            </section>

            <div class="buttons_action">
                {{ csrf_field() }}
                <button type="submit" id="likeCount">J'aime (...)</button>
                <p id="error"></p>
                <br>
            </div>
        </section>
        @else
        <section>Commentaire masqué</section>
        @endif
        @else
        <section class="event-article-commentary">
            <h3 class="{{ 'event-article-commentary-title-' . ($i%2 == 0 ? 'right' : 'left') }}">{{ $comment->user()->name }} and and {{$comment->hidden}}</h3>

            <section class="{{ 'event-article-commentary-text-' . ($i%2 == 0 ? 'right' : 'left') }}">
                <p class="comment-flex-area">{{ $comment->text }}</p>
            </section>

        </section>

        @if($comment->hiden)
        <p>Commentaire déjà masqué</p>
        @else
        <form action="/comment/validationMessage" method="POST">
            {{csrf_field()}}

            <input type="hidden" value="{{$comment->id}}" name="comment_id">
            <input class="btn btn-lg btn-filled" type="submit" value="Signaler"/>
        </form>
        @endif
        @endif

    @endforeach

    </div>

@endsection

@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<script src="{{ asset('/js/like.js') }}"></script>
@endsection
