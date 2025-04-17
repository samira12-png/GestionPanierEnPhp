<?php
require_once 'functionsProduit.php';

if (!isset($_SESSION['produits'])) {
    $_SESSION['produits'] = [
        ["id" => 1, "intitule" => "Produit A", "prix" => 150, "image" => "..."],
        ["id" => 2, "intitule" => "Produit B", "prix" => 300, "image" => "..."],
        ["id" => 3, "intitule" => "Produit C", "prix" => 200, "image" => "..."]
    ];
}


if (isset($_GET['add'])) {
    addToCart($_GET['add']);
    header("Location: indexProduit.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">MyProduct</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="indexProduit.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="addProduit.php">AddProduit</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="panierProduit.php">🛒<span class="badge bg-success"><?= getCartCount() ?></span> </a></li>

                </ul>
            </div>
        </div>
    </nav>
    <div class="row">
        <?php foreach ($_SESSION['produits'] as $prod): ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="<?= $prod['image'] ?>" class="card-img-top" style="height: 200px;">
                    <div class="card-body">
                        <h5><?= $prod['intitule'] ?></h5>
                        <p>Prix : <?= $prod['prix'] ?> DH</p>
                        <a href="?add=<?= $prod['id'] ?>" class="btn btn-success">Ajouter au panier</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>