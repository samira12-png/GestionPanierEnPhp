<?php

require_once 'functionsProduit.php';

if (isset($_GET['inc']) && isset($_SESSION['cart'][$_GET['inc']])) {
    $_SESSION['cart'][$_GET['inc']]['qte']++;
}

if (isset($_GET['dec']) && isset($_SESSION['cart'][$_GET['dec']])) {
    $_SESSION['cart'][$_GET['dec']]['qte']--;
    if ($_SESSION['cart'][$_GET['dec']]['qte'] <= 0) {
        unset($_SESSION['cart'][$_GET['dec']]);
    }
}

if (isset($_GET['del']) && isset($_SESSION['cart'][$_GET['del']])) {
    unset($_SESSION['cart'][$_GET['del']]);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Panier</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
<?php if (!empty($_SESSION['cart'])): ?>
<?php else: ?>
    <p class="alert alert-info">Votre panier est vide 🛒</p>
<?php endif; ?>

<div class="container mt-4">
    <h3>Mon panier</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Image</th>
                <th>Intitulé</th>
                <th>Prix Unitaire</th>
                <th>Quantité</th>
                <th>Prix Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($_SESSION['cart'] ?? [] as $id => $item): ?>
            <tr>
                <td><img src="<?= $item['image'] ?>" width="50"></td>
                <td><?= $item['intitule'] ?></td>
                <td><?= $item['prix'] ?> DH</td>
                <td>
                    <a href="?dec=<?= $id ?>" class="btn btn-sm btn-warning">-</a>
                    <?= $item['qte'] ?>
                    <a href="?inc=<?= $id ?>" class="btn btn-sm btn-success">+</a>
                </td>
                <td><?= $item['prix'] * $item['qte'] ?> DH</td>
                <td><a href="?del=<?= $id ?>" class="btn btn-sm btn-danger">🗑️ Supprimer</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <h5 class="text-end">Montant total : <strong><?= totalCart() ?> DH</strong></h5>
</div>
</body>
</html>
