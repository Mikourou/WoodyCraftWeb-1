<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture Commande</title>

</head>
<body>
    <h1>Détails de votre Commande</h1>

        <h2>Commande #{{ $order->id }}</h2>
        <p>Date de la commande : {{ $order->date_commande }}</p>
        <p>Type de paiement : {{ $order->type_paiement }}</p>
        <p>Méthode de paiement : {{ $order->methode_paiement }}</p>
        <p>Statut de la commande : {{ $order->statut_commande }}</p>
        <p>Total : {{ $order->total_prix }} €</p>

        <h3>Articles :</h3>
        <table>
            <thead>
                <tr>
                    <th>Nom de l'article</th>
                    <th>Prix Unitaire</th>
                    <th>Quantité</th>
                </tr>
            </thead>
            <tbody>
                @foreach (json_decode($order->articles, true) as $article)
                    <tr>
                        <td>{{ $article['nom'] }}</td>
                        <td>{{ $article['prix'] }} €</td>
                        <td>{{ $article['quantity'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</body>
</html>
