<?php
session_start(); 

function addToCart($id) {
    foreach ($_SESSION['produits'] as $prod) {
        if ($prod['id'] == $id) {
            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]['qte']++;
            } else {
                $_SESSION['cart'][$id] = [
                    "id" => $prod['id'],
                    "intitule" => $prod['intitule'],
                    "prix" => $prod['prix'],
                    "image" => $prod['image'],
                    "qte" => 1
                ];
            }
            break;
        }
    }
}

function getCartCount() {
    $count = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $count += $item['qte'];
        }
    }
    return $count;
}

function totalCart() {
    $total = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['prix'] * $item['qte'];
        }
    }
    return $total;
}
