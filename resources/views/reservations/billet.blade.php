<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Billet</title>
</head>
<body>
<h1>{{$billet->reservation->evenement->titre}}</h1>
<p>{{$billet->reservation->evenement->description}}</p>
<p>Date et heure de l'événement : {{$billet->reservation->evenement->date_debut}}</p>
<p>Lieu de l'événement : {{$billet->reservation->evenement->lieu->nom}}</p>
<p>Quantite : {{$billet->quantite}}</p>
</body>
</html>
