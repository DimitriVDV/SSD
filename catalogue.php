<?php require_once "connexion.php";
session_start();
//Panier de l'utilisateur
if (!isset($_SESSION["panier"])) {
    $_SESSION["panier"] = [];
}
// search
$search = $_GET['search'] ?? '';

$sql = "
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
INNER JOIN marque m ON a.marque_id = m.id
INNER JOIN categories c ON a.categorie_id = c.id
INNER JOIN dimensions_cm3 d ON a.dimension_id = d.id
LEFT JOIN images i ON a.images_id = i.id
LEFT JOIN reservation r ON a.reservation_id = r.id
";

$params = [];

if (!empty($search)) {
    $sql .= "
    WHERE (
        a.nom LIKE :search1
        OR m.marque LIKE :search2
        OR d.cm3 LIKE :search3
        OR c.modele LIKE :search4
    )";

    $params = [
        ':search1' => "%$search%",
        ':search2' => "%$search%",
        ':search3' => "%$search%",
        ':search4' => "%$search%"
    ];
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$article = $stmt->fetchAll();
?>

    <?php include 'components/header.php';

    if (isset($_POST['add'])) {

        $id = $_POST['id'];

        foreach ($article as $a) {
            if ($a['id'] == $id) {

                $found = false;

                foreach ($_SESSION['panier'] as &$item) {
                    if ($item['id'] == $id) {
                        $item['quantite']++;
                        $found = true;
                        break;
                    }
                }

                if (!$found) {
                    $_SESSION['panier'][] = [
                        'id' => $a["id"],
                        "nom" => $a["nom"],
                        "marque" => $a["marque"],
                        "prix" => $a["prix"],
                        "quantite" => 1
                    ];
                }

                break;
            }
        }

        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    if (isset($_POST['clear'])) {
        unset($_SESSION['panier']);
    }

    // Catalogue   
    ?>
    <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 w-3/4 m-auto">
        <?php
        //chaque produit card
        foreach ($article as $a) { ?>

            <article class="flex flex-col bg-gray-100 p-4 rounded-xl shadow-sm">
                <a href="product.php?id=<?= $a['id'] ?>">
                    <h2 class="font-bold mb-1">
                        <?= $a["marque"] . " " . $a["nom"] ?>
                    </h2>

                    <span class="text-gray-600 mb-2">
                        <?= $a["prix"] ?> €
                    </span>

                    <img
                        src="<?=$a['URL2']?>"
                        class="w-full h-40 object-center object-cover mb-3"
                        alt="photo moto <?= $a['nom'] ?>">
                </a>
                <form method="post" class="mt-auto">
                    <input type="hidden" name="id" value="<?= $a["id"] ?>">
                    <!--ajouter au panier-->
                    <button
                        type="submit"
                        name="add"
                        class="w-full bg-blue-500 p-2 rounded-xl text-white hover:opacity-80 hover:-translate-y-1 transition">
                        add
                    </button>
                </form>

            </article>
        <?php } ?>
    </section>

    <button onclick="toggleCart()" class="fixed bottom-6 right-6 bg-blue-500 text-white px-4 py-3 rounded-full shadow-lg 
    hover:scale-110 transition">
        Cart
    </button>
    <?php include 'components/cart.php'; ?>
</body>

</html>