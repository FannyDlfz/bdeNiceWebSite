@extends('template')

@section('content')
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <div id="main">
            <div class="orange-bar">
                <p id="inside-bar" style="margin:30px;">Prochainement au BDE...</p>
            </div>
        </div>
    </div>
    <div class="table">
        <table class="table-elements">
            <thead class="table-top">
            <tr>
                <th>Nom du Produit</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach($basket->articles as $article)

                    <tr>
                        <td>{{$article->name}}</td>
                        <td>{{$article->price}} €</td>
                        <td>1</td>
                        <td>
                            <form method="POST" action="{{ route('basket.remove-article', $basket->user_id) }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <input type="hidden" name="article_id" value="{{ $article->id }}">
                                <button type="submit" class="fas fa-trash"></button>
                            </form>
                        </td>
                    </tr>

                @endforeach
            </tbody>
        </table>
    </div>
    <p>
        <a href="{{route('mails.validationMail')}}" class="button-event-basket">Acheter</a>
    </p>
@endsection

@section('scripts')

    <script src="{{ asset('/js/animations.js') }}"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
@endsection
