@extends('template')

@section('content')
    <div id="sidenav" class="sidenav">
        <form action="/articles/search" method="GET" class="search-form">
            {{csrf_field()}}
            <a href="javascript:void(0)" class="closebtn" onclick="toggleNav()">&times;</a>

            <!-- ================================ AUTOCOMPLETE SEARCH BAR ================================== -->

            <div class="input-group search-bar">
                <input type="search" name="search" placeholder="Rechercher un article" class="form-control" id="article">
                <span class="input-group-prepend">
                    <button type="submit" class="btn btn-primary">Recherche</button>
                </span>
                <i class='fa fa-search'></i>
            </div>

            <style>
                * { box-sizing: border-box; }
                body {
                    font: 16px Arial;
                }

                input {
                    border: 1px solid transparent;
                    background-color: #f1f1f1;
                    padding: 10px;
                    font-size: 16px;
                }
                input[type=text] {
                    background-color: #f1f1f1;
                    width: 100%;
                }
                input[type=submit] {
                    background-color: DodgerBlue;
                    color: #fff;
                }
                .autocomplete-items {
                    position: absolute;
                    border: 1px solid #d4d4d4;
                    border-bottom: none;
                    border-top: none;
                    z-index: 99;
                    /*position the autocomplete items to be the same width as the container:*/
                    top: 100%;
                    left: 0;
                    right: 0;
                }
                .autocomplete-items div {
                    padding: 10px;
                    cursor: pointer;
                    background-color: #fff;
                    border-bottom: 1px solid #d4d4d4;
                }
                .autocomplete-items div:hover {
                    /*when hovering an item:*/
                    background-color: #e9e9e9;
                }
            </style>

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
            <p id="inside-bar" style="margin:30px;">Nos articles</p>
        </div>
    </div>

    <section class="main-event">
        <div class="event-section">

            @php $i = 0 @endphp

            @foreach($articles as $article)

                @if($i % 3 == 0)

                    @if($i != 0)

        </div>

        @endif

        <div class="event-box">

            @endif

            <div class="event-container-container">
                <article class="event-container">

                        <div class="event-img">
                            <img class="image"  src="{{( preg_match('#^https://.*#', $article->pictures[0]->name)
                            ? $article->pictures[0]->name
                            :  asset('/article-photos/' . \App\Gestion\SlugGestion::slugify($article->pictures[0]->name) . '.' . $article->pictures[0]->extension) )}}"
                                 alt="{{ $article->pictures[0]->name }}" />
                        </div>

                    <p class="eventtitle">{{ $article->name }}</p>
                    <p class="text">{{ $article->description }}</p>
                    <a href="/articles/{{$article->id}}" ><p class="buttonevent">En savoir plus</p></a>
                    <div class="d-flex justify-content-center mt-4">
                        @foreach($article->articleCategories as $category)
                            <small class="badge badge-success mx-1">{{ $category->name }}</small>
                        @endforeach
                    </div>
                    <p class="price">{{$article->price}} €</p>
                </article>
                <div class="event-background"></div>
            </div>

            @php $i++ @endphp

            @endforeach

        </div>
    </section>

    {!! $links !!}

@endsection

@section('scripts')

<script src="{{ asset('/js/animations.js') }}"></script>
<script src="{{ asset('/js/search.js') }}"></script>

@endsection
