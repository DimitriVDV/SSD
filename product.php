<?php 
require_once 'connexion.php';
include_once './components/header.php';
session_start();?>
<button onclick="toggleCart()" class="fixed bottom-6 right-6 bg-blue-500 text-white px-4 py-3 rounded-full shadow-lg 
    hover:scale-110 transition">
        Cart
    </button>

    <h2><?=  ?></h2>
    <?php include 'components/cart.php'; ?>
