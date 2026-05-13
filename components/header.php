<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSD : Motors</title>
    <link href="./src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  
</head>

<body class="flex flex-col bg-[#080808] text-white font-['DM_Sans'] text-[15px] leading-[1.6] min-h-screen">
    <script>
        function toggleCart() {
            const cart = document.getElementById('cart');
            cart.classList.toggle('translate-x-full');
        }
    </script>
<header
    class="sticky top-0 w-full h-15 bg-black z-50 ">
    <nav class="flex w-full px-8  items-center justify-between h-16
        jbg-[rgba(8,8,8,0.92)] backdrop-blur">
        <a href="catalogue.php" class=" w-full font-black text-[26px] text-[#e63946] no-underline">SSD : Motors</a>
        <div class="flex flex-row justify-end items-center gap-2 w-full">
            <form method="get" action="catalogue.php">
                <input name="search" type="text" placeholder="Recherche" class="w-full px-5 py-2 rounded-2xl shadow-sm shadow-[#c1121f] bg-stone-800">
            </form> 
            <a href="compte.php">compte</a>
        </div>
        
    </nav>
</header>