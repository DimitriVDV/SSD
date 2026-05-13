<?php
session_start();
require_once './includes/auth.php';
require_once './includes/connexion.php';
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
<h2 id="article-title" class="flex p-5 text-6xl font-black"><?= $product['marque'] ?> <?= $product['nom'] ?></h2>
<section class="flex relative w-full flex-col sm:flex-row mx-auto z-0">

    <article class="flex flex-col w-full sm:w-2/3">
        <img src="<?= $product['URL'] ?>" alt="">
        <div class="flex">
            <img src="<?= $product['URL1'] ?>" class="object-cover w-1/2" alt=""><img src="<?= $product['URL2'] ?>" class="object-cover w-1/2" alt="">
        </div>
    </article>
    <aside  class="sticky top-24  flex flex-1 flex-col self-start w-full bg-stone-900 mx-5 p-5 rounded-2xl shadow-lg shadow-[#c1121f]">
        <div id="aside" class="relative">
            <h2 id="floating-title" class="absolute top-0 left-0 translate-y-2 opacity-0 transition-all duration-300 text-white text-2xl font-bold">
                <?= $product['marque'] ?> <?= $product['nom'] ?></h2>

            <p class=" text-xl font-semibold">à partir de </p>

            <h3 class="text-3xl font-bold"><?= $product['prix'] ?> €/jour</h3>

            <p class="m-5">
                <span class="px-2 py-1 text-black bg-gray-200 rounded-xl inline"><?= $product['cm3'] ?> cc</span>
                <span class="px-2 py-1 text-black bg-gray-200 rounded-xl inline">Permis A</span>
            </p>
            <p class="">
                <span class="px-2 py-1 text-black bg-green-300 rounded-xl ">Assurance comprise</span>
                <span class="px-2 py-1 text-black bg-blue-200 rounded-xl ">Annulation gratuite</span>
            </p>
            <form method="post" class="px-5 pb-5 mt-5">
                <input type="hidden" name="id" value="<?= $product["id"] ?>">

                <button
                    type="submit"
                    name="add"
                    class="w-full bg-[#e63946] hover:bg-[#c1121f] text-white font-semibold 
                py-3 rounded-xl transition-all duration-200 hover:shadow-[0_6px_30px_rgba(230,57,70,0.35)]">
                    Réservez
                </button>
            </form>
        </div>
    </aside>

</section>
<section class="flex flex-col sm:flex-row justify-center items-center px-20 bg-black ">
    <article class="flex flex-col justify-start items-center bg-black w-1/2 py-5">
        <h2 class="font-bold text-xl">fiche technique</h2>
        <p>
            cylindrée: <?= $product['cm3'] ?> cm<sup>3</sup>
        </p>
    </article>
    <article class=" flex flex-col justify-start items-center  w-1/2 py-5">
        <h2 class="font-bold text-xl">azde </h2>

    </article>
</section>


<button
    onclick="toggleCart()"
    class="fixed bottom-6 right-6 bg-[#e63946] hover:bg-[#c1121f] px-5 py-4 rounded-full shadow-[0_8px_30px_rgba(230,57,70,0.4)] 
    hover:scale-110 transition-all duration-200 font-semibold">
    Cart
</button>


<?php include 'components/cart.php'; ?>
<script src="./src/index.js"></script>
</body>

</html>