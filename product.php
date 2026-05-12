<?php 
session_start();
require_once 'connexion.php';
include_once './components/header.php';

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    die("Erreur produit");
}

$stmt = $pdo->prepare("
SELECT 
    a.id, 
    a.nom,
    a.prix,
    c.modele,
    d.cm3,
    m.marque,
    i.URL,
    i.URL1,
    i.URL2

FROM annonces a

INNER JOIN marque m 
    ON a.marque_id = m.id

INNER JOIN categories c 
    ON a.categorie_id = c.id

INNER JOIN dimensions_cm3 d 
    ON a.dimension_id = d.id

LEFT JOIN images i 
    ON a.images_id = i.id

LEFT JOIN reservation r 
    ON a.reservation_id = r.id

WHERE a.id = ?
");

$stmt->execute([$id]);

$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Produit non trouvé");
}
?>
<section class="flex relative w-full flex-col sm:flex-row mx-auto z-0">
    <h2 class="flex absolute top-0 left-0 p-5 text-6xl font-black"><?= $product['marque'] ?> <?= $product['nom'] ?></h2>
    <article class="flex flex-col w-full sm:w-2/3">
        <img src="<?= $product['URL'] ?>" alt="">
        <div class="flex">
            <img src="<?= $product['URL1'] ?>" class="object-cover w-1/2" alt=""><img src="<?= $product['URL2'] ?>" class="object-cover w-1/2"alt="">
        </div>
    </article>
    <aside class="flex flex-1 flex-col w-full justify-start items-end p-5 mx-3 bg-gray-200 rounded-2xl shadow-lg">
        <p class=" text-xl font-semibold">à partir de </p>
        <h3 class="text-3xl font-bold"><?= $product['prix'] ?> €/jour</h3>
    </aside>
    
</section>


<button onclick="toggleCart()" class="fixed bottom-6 right-6 bg-blue-500 text-white px-4 py-3 rounded-full shadow-lg 
    hover:scale-110 transition">
        Cart
    </button>


    <?php include 'components/cart.php'; ?>
