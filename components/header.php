<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="./src/output.css" rel="stylesheet">
</head>

<body class="flex flex-col">
    <script>
        function toggleCart() {
            const cart = document.getElementById('cart');
            cart.classList.toggle('translate-x-full');
        }
    </script>
<header
    class="sticky top-0 w-full h-15 z-50 p-3 shadow-lg">
    <nav class="flex w-full justify-between items-center ">
        <a href="catalogue.php" class="font-black text-2xl w-full">SSD : Motors</a>
        <div class="flex flex-row justify-between items-center gap-2 w-full">
            <form method="get">
                <input name="search" type="text" placeholder="Recherche" class="w-full px-5 py-2 rounded-2xl shadow-lg bg-white">
            </form> 
            <a href="compte.php">compte</a>
        </div>
        
    </nav>
</header>