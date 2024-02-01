<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invitacion al evento</title>
</head>
<body>
    Estas cordialmente invitado al evento: {{$eventInfo->data()['name']}} . {{$eventInfo->data()['description']}}
    {{QrCode::generate('invitdado al evento')}}
    
</body>
</html>
