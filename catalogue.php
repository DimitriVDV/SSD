<?php 
// ============================================================
// pages/catalogue.php
// ============================================================
$pageTitle = 'Catalogue';
session_start();
require_once './includes/auth.php';
require_once "./includes/connexion.php";
// Filters
$filterCat   = $_GET['categorie']  ?? '';
$filterMarque= $_GET['marque']     ?? '';
$filterCm3   = $_GET['cm3']        ?? '';

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

if ($filterCat) {
    $sql .= " AND a.categorie_id = ?";
    $params[] = $filterCat;
}
if ($filterMarque) {
    $sql .= " AND a.marque_id = ?";
    $params[] = $filterMarque;
}
if ($filterCm3) {
    $sql .= " AND a.dimension_id = ?";
    $params[] = $filterCm3;
}
$sql .= " ORDER BY a.id DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$article = $stmt->fetchAll();

$categories = $pdo->query("SELECT * FROM categories ORDER BY modele")->fetchAll();
$marques    = $pdo->query("SELECT * FROM marque ORDER BY marque")->fetchAll();
$dims       = $pdo->query("SELECT * FROM dimensions_cm3 ORDER BY cm3")->fetchAll();
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
   
    ?><!-- Catalogue -->
<section class=" mx-auto px-8 py-10">
    
    <div class="flex items-center justify-between mb-10">
        <div>
            <h1 class="text-4xl font-bold text-white">
                Catalogue
            </h1>
            <p class="text-[#666] mt-2">
                Découvrez nos motos disponibles
            </p>
        </div>

        <!-- FILTERS -->
<div class="w-full max-w-6xl mx-auto px-6 mb-8">

  <form method="GET"
    class="flex flex-col md:flex-row md:items-center gap-4 bg-[#111111] border border-[#222222] rounded-2xl p-4">

    <!-- Catégorie -->
    <select name="categorie"
      class="w-full md:w-auto bg-[#1a1a1a] border border-[#222222] text-white px-4 py-3 rounded-xl 
      focus:border-[#e63946] outline-none transition">

      <option value="">Toutes catégories</option>
      <?php foreach ($categories as $c): ?>
        <option value="<?= $c['id'] ?>" <?= $filterCat == $c['id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($c['modele']) ?>
        </option>
      <?php endforeach; ?>

    </select>

    <!-- Marque -->
    <select name="marque"
      class="w-full md:w-auto bg-[#1a1a1a] border border-[#222222] text-white px-4 py-3 rounded-xl 
      focus:border-[#e63946] outline-none transition">

      <option value="">Toutes marques</option>
      <?php foreach ($marques as $m): ?>
        <option value="<?= $m['id'] ?>" <?= $filterMarque == $m['id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($m['marque']) ?>
        </option>
      <?php endforeach; ?>

    </select>

    <!-- Cylindrée -->
    <select name="cm3"
      class="w-full md:w-auto bg-[#1a1a1a] border border-[#222222] text-white px-4 py-3 rounded-xl 
      focus:border-[#e63946] outline-none transition">

      <option value="">Toutes cylindrées</option>
      <?php foreach ($dims as $d): ?>
        <option value="<?= $d['id'] ?>" <?= $filterCm3 == $d['id'] ? 'selected' : '' ?>>
          <?= (int)$d['cm3'] ?> cm³
        </option>
      <?php endforeach; ?>

    </select>

    <!-- Bouton filtrer -->
    <button type="submit"
      class="bg-[#e63946] hover:bg-[#c1121f] text-white font-semibold px-6 py-3 rounded-xl 
      transition-all duration-200 w-full md:w-auto">
      Filtrer
    </button>

    <!-- Reset -->
    <?php if ($filterCat || $filterMarque || $filterCm3): ?>
      <a href="catalogue.php"
        class="text-[#e63946] hover:text-[#c1121f] font-medium transition w-full md:w-auto text-center">
        ✕ Réinitialiser
      </a>
    <?php endif; ?>

    <!-- Résultat -->
    <span class="text-[#666] text-sm w-full md:w-auto text-center md:text-left">
      <?= count($article) ?> moto<?= count($article) !== 1 ? 's' : '' ?>
    </span>

  </form>

</div>

    </div>

    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

        <?php foreach ($article as $a) { ?>

            <article class="group bg-[#111111] border border-[#222222] rounded-2xl overflow-hidden 
            hover:border-[#e63946] transition-all duration-300 hover:-translate-y-1">

                <a href="product.php?id=<?= $a['id'] ?>" class="block">

                    <div class="overflow-hidden bg-black">
                        <img
                            src="<?= $a['URL2'] ?>"
                            class="w-full h-56 object-cover group-hover:scale-105 transition duration-500"
                            alt="photo moto <?= $a['nom'] ?>">
                    </div>

                    <div class="p-5 flex flex-col gap-3">

                        <div class="flex items-center justify-between">
                            <span class="text-xs uppercase tracking-widest text-[#666]">
                                <?= $a["modele"] ?>
                            </span>

                            <span class="text-xs bg-[#1a1a1a] border border-[#222222] px-2 py-1 rounded-lg text-[#999]">
                                <?= $a["cm3"] ?> cm³
                            </span>
                        </div>

                        <h2 class="text-xl font-bold text-white leading-tight">
                            <?= $a["marque"] . " " . $a["nom"] ?>
                        </h2>

                        <div class="flex items-center justify-between pt-2">

                            <span class="text-2xl font-bold text-[#e63946]">
                                <?= $a["prix"] ?> €/jour
                            </span>

                        </div>
                    </div>
                </a>

                <form method="post" class="px-5 pb-5">
                    <input type="hidden" name="id" value="<?= $a["id"] ?>">

                    <button
                        type="submit"
                        name="add"
                        class="w-full bg-[#e63946] hover:bg-[#c1121f] text-white font-semibold 
                        py-3 rounded-xl transition-all duration-200 hover:shadow-[0_6px_30px_rgba(230,57,70,0.35)]">
                        Réservez
                    </button>
                </form>

            </article>

        <?php } ?>

    </section>
</section>

<!-- Floating Cart -->
<button 
    onclick="toggleCart()" 
    class="fixed bottom-6 right-6 bg-[#e63946] hover:bg-[#c1121f] px-5 py-4 rounded-full shadow-[0_8px_30px_rgba(230,57,70,0.4)] 
    hover:scale-110 transition-all duration-200 font-semibold">
    Cart
</button>
    <?php include 'components/cart.php'; ?>
    </body>

</html>