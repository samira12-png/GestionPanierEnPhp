<?php
session_start(); // Démarrer la session

$errors = [];
$validExt = ['png', 'jpeg', 'gif', 'jpg'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prix = htmlspecialchars(trim($_POST['prix']));
    $image = $_FILES['image'];

    if (empty($nom)) {
        $errors['nom'] = "Le nom est vide.";
    } elseif (strlen($nom) < 3) {
        $errors['nom'] = "Le nom doit contenir au moins 3 caractères alphabétiques.";
    }

    if (empty($prix)) {
        $errors['prix'] = "Le prix est vide.";
    } elseif ($prix < 100 || $prix > 500) {
        $errors['prix'] = "Le prix doit être compris entre 100 et 500.";
    }

    if (empty($image['name'])) {
        $errors['image'] = "L'image est obligatoire.";
    } elseif ($image['error'] != 0) {
        $errors['image'] = "Erreur de chargement de l'image.";
    } else {
        $tempDir = $image['tmp_name'];
        $fileName = $image['name'];
        $size = $image['size'];
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($extension, $validExt)) {
            $errors['image'] = "L'image choisie est invalide (format autorisé: png, jpeg, gif, jpg).";
        }
    }

    if (empty($errors)) {
        $newImageName = "images/" . uniqid() . "." . $extension;
        move_uploaded_file($tempDir, $newImageName);

        $newProduct = [
            "id" => time(), // ID unique basé sur le timestamp
            "intitule" => $nom,
            "prix" => $prix,
            "image" => $newImageName
        ];

        if (isset($_SESSION['produits'])) {
            $produits = $_SESSION['produits'];
        } else {
            $produits = [];
        }
        

        $produits[] = $newProduct;

        $_SESSION['produits'] = $produits;

        header('Location: indexProduit.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<style type="text/css">
    body{
        background-color:rgb(215, 233, 180);
    }
</style>
</head>
<body>
    <div class="container p-3 border border-5 border-success w-50 mt-5" style="background-color:rgb(160, 201, 78);border-radius:25px">
        <h3 class="text-center bg-light p-3" style="font-family:Ariel;font-weight:bold;border-radius:25px">AJouter Un Produit</h3>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>"  method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nom">Nom:</label>
                <input type="text" class="form-control" name="nom" value="<?= $nom ?? '' ?>" />
                <div class="text-danger"><?= $errors['nom'] ?? '' ?></div>

            </div>
            <div class="mb-3">
                <label for="prix">Prix:</label>
                <input type="number" class="form-control" name="prix" value="<?= $prix ?? '' ?>"/>
                <div class="text-danger"><?= $errors['prix'] ?? '' ?></div>

            </div>
            <div class="mb-3">
                <label for="image">Image:</label>
                <input type="file" class="form-control" name="image" />


                <div class="text-danger"><?= $errors['image'] ?? '' ?></div>

            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-sm btn-info">Ajouter</button>
            </div>
        </form>
    </div>
</body>
</html>