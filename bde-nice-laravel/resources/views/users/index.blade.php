@extends('template')

@section('content')

    {{--<!--{!! $i = 0; !!}

    @foreach($users as $user)

        @if($i % 3 == 0)

            @if($i != 0)

                </div>

            @endif

            <div class="event_box">

        @endif

            <div class="event-container-container">
                <article class="event_container">
                    <p class="eventtitle">{{ $user->name }}</p>
                    <p class="text">{{ $user->role->{'name'} }}{{ $user->center->{'name'} }}</p>
                    <p class="buttonevent">Profil</p>
                </article>
                <div class="event_background"></div>
            </div>

        {!! $i++ !!}

    @endforeach

   <div class="event_box">
        <div class="event-container-container">
            <article class="event_container">
                <div class="event_img"> <img class="image"  src="assets\img\CAPSvsDOINB.jpg" alt="" /></div>
                <p class="eventtitle">Tournoi de merde</p>
                <p class="text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. </p>
                <p class="buttonevent">voir plus</p>
            </article>
            <p class="event_background">Samedi 5 octobre à 12:00</p>
        </div>
        <div class="event-container-container">
            <article class="event_container">
                <div class="event_img"> <img class="image"  src="assets\img\image_3.png" alt="" /></div>
                <p class="eventtitle">Tournoi de merde</p>
                <p class="text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. </p>
                <p class="buttonevent">Voir le profil</p>
            </article>
            <p class="event_background">Samedi 5 octobre à 12:00</p>
        </div>
        <div class="event-container-container">
            <article class="event_container">
                <div class="event_img"> <img class="image"  src="assets\img\image_3.png" alt="" /></div>
                <p class="eventtitle">Tournoi de merde</p>
                <p class="text">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. </p>
                <p class="buttonevent">voir plus</p>
            </article>
            <p class="event_background">Samedi 5 octobre à 12:00</p>
        </div>
    </div>-->--}}

    <h1>Liste des utilisateurs utilisés à des fins d'utilisation utile</h1>

    @if(session()->has('user'))
        <p>Bienvenue, <a href="/users/{{ session()->has('user') }}">{{ session('username') }}</a></p>
        <a href="/logout" type="button">Je rentre à ma maison</a>
    @else
        <a href="/users/create" type="button">Je veux faire partie de cette aventure tumultueuse et semée d'embûches !</a><br/>
        <a href="/login" type="button">Je suis un aventurier et je veux me faire entendre !</a><br/>
    @endif

    @foreach($users as $user)

        <hr/>
        <h3>{{ $user->name }}</h3>
        <p>{{ $user->email  }}</p>
        <ul>
            <li>Centre: {{ $user->center->{'_name'} }}</li>
            <li>Role: {{ $user->role->{'_name'} }}</li>
        </ul>

        <a href="/users/{{ $user->id }}" type="button">En savoir plus</a><br/>
        @if(session()->has('user'))
            @if(session('user') == $user->id)

                <a href="/users/{{ $user->id }}/edit" type="button">Modifier</a><br/>
                <form method="POST" action="/users/{{ $user->id }}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <input type="submit" value="Supprimer de l'espace intersidéral"/>
                </form>

            @endif
        @endif

    @endforeach

@endsection
