@extends('template')

@section('content')

    <div id="sidenav" class="sidenav">
        <form action="/events/search" method="GET" class="search-form">
            {{csrf_field()}}
            <a href="javascript:void(0)" class="closebtn" onclick="toggleNav()">&times;</a>
            <div class="input-group search-bar">
                <input type="search" name="search" placeholder="Rechercher..." class="form-control">
                <span class="input-group-prepend">
                    <button type="submit" class="btn btn-primary">Recherche</button>
                </span>
                <i class='fa fa-search'></i>
            </div>
            <h1 class="sidebar-title">Domaine...</h1>
            <hr>
                <select multiple name="categories[]" size="{{ count($eventCategories) }}">

                    @foreach($eventCategories as $category)

                        <option value="{{$category->id}}">{{ $category->name }}</option>

                    @endforeach

                </select>
            <h1 class="sidebar-title">Prix...</h1>
            <hr>
            <div class="d-flex justify-content-center">
                <input type="number" class="form-control" name="price-min" placeholder="Prix minimum"/>
                <input type="number" class="form-control" name="price-max" placeholder="Prix maximum"/>
            </div>
            <h1 class="sidebar-title">Etat...</h1>
            <hr>
            <br>
            <div class="d-flex justify-content-center flex-column">
                <div><label class="mr-4" for="scheduled">Evènements programmés</label><input id="scheduled" type="checkbox" name="scheduled"/></div>
                <div><label class="mr-4" for="past">Evènements passés</label><input id="past" type="checkbox" name="past"/></div>
                <div><label class="mr-4" for="proposed">Evènements non confirmés</label><input id="proposed" type="checkbox" name="proposed"/></div>
            </div>
            <br>
            <h1 class="sidebar-title">Trier par...</h1>
            <hr>
            <div class="d-flex justify-content-center">
                <select name="sort">
                    <option value="begin_at">Date</option>
                    <option value="name">Nom</option>
                </select>
                <select name="sort-direction">
                    <option value="ASC">Croissant</option>
                    <option value="DESC">Décroissant</option>
                </select>
            </div>
        </form>
        <span id="side-menu" class="side-menu"  onclick="toggleNav()">&#9776;</span>
    </div>
    <div id="main">
        <div class="orange-bar">
            <p id="inside-bar" style="margin:30px;">Prochainement au BDE...</p>
        </div>
    </div>

    <a href="{{ route('event-photos.download') }}" class="btn btn-outline-warning">Télécharger toutes les photos des évènements</a>

    <section class="main-event">

        <div class="event-section">

            @php $i = 0 @endphp

            @foreach($events as $event)

                @if($i % 3 == 0)

                    @if($i != 0)

                        </div>

                    @endif

                    <div class="event-box">

                @endif

                <div class="event-container-container">
                    <article class="event-container">
                        <div class="event-img">
                            <img class="image" src="{{( preg_match('#^https?:\/\/.*#', $event->pictures[0]->name)
            ? $event->pictures[0]->name
            : asset('/event-photos/' . \App\Gestion\SlugGestion::slugify($event->pictures[0]->name) . '.' . $event->pictures[0]->extension) )}}"
                            alt="{{ $event->pictures[0]->name }}" />
                        </div>
                        <h2 class="eventtitle">{{ $event->name }}</h2>
                        <h3 class="text">{{ $event->description }}</h3>
                        <a href="/events/{{$event->id}}" ><p class="buttonevent">En savoir plus</p></a>
                        <div class="d-flex justify-content-center mt-4">
                            @foreach($event->eventCategories as $category)
                                <small class="badge badge-success mx-1">{{ $category->name }}</small>
                            @endforeach
                        </div>
                        @if($event->scheduled)
                            <small class="badge badge-success mx-auto d-block w-25 mt-4">Programmé</small>
                        @endif
                        <p class="price">{{$event->price}} €</p>
                    </article>
                    <div class="event-background">De {{$event->begin_at }} à {{$event->end_at }}</div>
                </div>

                @php $i++ @endphp

            @endforeach
        </div>

        </div>
    </section>

    {!! $links !!}

@endsection

@section('scripts')

    <script src="{{ asset('/js/animations.js') }}"></script>

@endsection
