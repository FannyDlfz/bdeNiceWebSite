@extends('admin.admin-template')

@section('title', 'Administration')

@section('content')

    <div class="table">
        <table class="table-elements">
            <thead class="table-top">
                <tr>
                    <th>Nom : <i class="fas fa-sort"></i></th>
                    <th>Prix : <i class="fas fa-sort"></i></th>
                    <th>Date d'ajout : <i class="fas fa-sort"></i></th>
                    <th>Date de mise à jour : <i class="fas fa-sort"></i></th>
                    <th></th>
                    <th><a href="{{ route('articles.create') }}" class="fas fa-plus-circle fa-3x"></a></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@stop

@section('scripts')

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/Entity.js')}}" lang="js"></script>
    <script src="{{ asset('js/AdminPanel.js')}}" lang="js"></script>
    <script lang="js">
        new AdminPanel('articles', ['name', 'price', 'created_at', 'updated_at']);
    </script>

@stop


