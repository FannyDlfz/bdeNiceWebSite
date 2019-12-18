@extends('template')

@section('content')
    <div id="sidenav" class="sidenav">
        <form action="/articles/search" method="GET" class="search-form">
            {{csrf_field()}}
            <a href="javascript:void(0)" class="closebtn" onclick="toggleNav()">&times;</a>

            <div class="input-group search-bar">
                <input type="search" name="search" placeholder="Rechercher un article" class="form-control" id="article">
                <span class="input-group-prepend">
                    <button type="submit" class="btn btn-primary">Recherche</button>
                </span>
                <i class='fa fa-search'></i>
            </div>

            <h1 class="sidebar-title">Domaine...</h1>

            <hr>
            <select multiple name="categories[]" size="{{ count($articleCategories) }}">

                @foreach($articleCategories as $category)

                    <option value="{{$category->id}}">{{ $category->name }}</option>

                @endforeach
            </select>
            <h1 class="sidebar-title">Prix...</h1>
            <hr>
            <div class="d-flex justify-content-center">
                <input type="number" class="form-control" name="price-min" placeholder="Prix minimum"/>
                <input type="number" class="form-control" name="price-max" placeholder="Prix maximum"/>
            </div>
            <h1 class="sidebar-title">Trier par...</h1>
            <hr>
            <div class="d-flex justify-content-center">
                <select name="sort">
                    <option value="created_at">Date</option>
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
            <h1 id="inside-bar" style="margin:30px;">Nos articles</h1>
        </div>
    </div>

    <section class="main-event">
        <div class="event-section">

            @php $i = 0 @endphp

            @foreach($articles as $article)

        <div class="event-box">

            <div class="event-container-container">
                <article class="event-container">

                        <div class="event-img">
                            <img class="image"  src="{{( preg_match('#^https://.*#', $article->pictures[0]->name)
                            ? $article->pictures[0]->name
                            :  asset('/article-photos/' . \App\Gestion\SlugGestion::slugify($article->pictures[0]->name) . '.' . $article->pictures[0]->extension) )}}"
                                 alt="{{ $article->pictures[0]->name }}" />
                        </div>

                    <h2 class="eventtitle">{{ $article->name }}</h2>
                    <p class="text">{{ $article->description }}</p>
                    <a href="/articles/{{$article->id}}" ><p class="buttonevent">En savoir plus</p></a>
                    <div class="d-flex justify-content-center mt-4">
                        @foreach($article->articleCategories as $category)
                            <small class="badge badge-success mx-1">{{ $category->name }}</small>
                        @endforeach
                    </div>
                    <h3 class="price">{{$article->price}} €</h3>
                </article>
                <div class="event-background"></div>
            </div>

            @php $i++ @endphp
        </div>
            @endforeach

        </div>
    </section>

    {!! $links !!}

@endsection

@section('scripts')

<script src="{{ asset('/js/animations.js') }}"></script>
<script src="{{ asset('/js/search.js') }}"></script>

@endsection
