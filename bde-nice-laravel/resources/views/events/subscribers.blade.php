<!DOCTYPE html>

<html lang="fr">

<head>
    <title>participants</title>
    <meta charset="utf-8">
</head>

<body>

<h1>{{$event->name}}</h1>

<section>

    <table class="table table-striped" border="1">
        <colgroup>
            <col width="30%">
            <col width="90%">
        </colgroup>
        <thead>
        <tr class='warning'>
            <th>User Name</th>
            <th>Email</th>
        </tr>
        </thead>
        <tbody>
        @foreach($userSub as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <button onclick="convert_HTML_To_PDF();">Convert to PDF</button>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
    <script src="/js/jspdf.debug.js" charset="utf-8"></script>

</section>

</body>

</html>
