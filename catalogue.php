<?php require_once "connexion.php";

$stmt = $pdo->query('SELECT * FROM annonces');
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
    <header
    class="sticky top-0 w-full h-15 z-50 p-3 shadow-lg">
    <nav class="flex justify-between items-center ">           
    <h1 class="font-black text-2xl">SSD : Motors</h1>
 
<a href="compte">compte</a>
</nav>
 </header>
<?php
foreach ($article as $a) {
 
}
?>
</body>
</html>
