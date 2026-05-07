<?php require_once "connexion.php";

$stmt = $pdo->prepare(
'SELECT a.nom, a.prix,
        c.modele,
        d.cm3,
        m.marque
FROM annonces a
INNER JOIN marque m ON a.marque_id = m.id
INNER JOIN categories c ON a.categorie_id = c.id
INNER JOIN dimensions_cm3 d ON a.dimension_id = d.id
LEFT JOIN reservation r ON a.reservation_id = r.id

');
$stmt -> execute();
$article = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <link href="./src/output.css" rel="stylesheet">
</head>
<body>
<?php include 'header.php';?>
<article class="flex flex-col w-full">
    <?php
foreach ($article as $a) {?>
 <h3 class="flex"><?= $a["marque"] ?> <?= $a['nom'] ?></h3>
 <p class="flex"><?= $a['modele'] ?> · <?= $a['cm3'] ?></p>
<?php } ?>
</article>

</body>
</html>
