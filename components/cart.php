<aside id="cart"
    class="fixed top-0 right-0 h-full w-80 bg-stone-900 shadow-2xl p-5 
transform translate-x-full transition-transform duration-500 ease-in-out z-50">

    <h2 class="text-xl font-bold mb-4 flex justify-between items-center">
        Panier
        <button onclick="toggleCart()" class="text-gray-500 hover:text-black">✕</button>
    </h2>
    <ul>
        <?php if (!empty($_SESSION['panier'])) {
            $total = 0;
            foreach ($_SESSION['panier'] as $item) {
                $sousTotal = $item['prix'] * $item['quantite'];
                $total += $sousTotal;
        ?>
                <li class="mb-2 border-b pb-2">
                    <a href="product.php?id=<?= $item['id'] ?>" class="block">
                        <span class="font-semibold">
                            <?= $item['marque'] ?> <?= $item['nom'] ?>
                        </span>
                    </a>

                    <p>
                        <?= $item['prix'] ?> € x <?= $item['quantite'] ?>
                    </p>

                    <span class="text-sm text-gray-600">
                        Sous-total : <?= $sousTotal ?> €
                    </span>
                </li>
        <?php }
        } ?>
    </ul>

    <div class="mt-4 font-bold">
        Total : <?= isset($total) ? $total : 0 ?> €
    </div>
    <form method="post">
        <button
            type="submit"
            name="clear"
            class="w-full p-2 rounded-xl text-red-500 hover:opacity-80 hover:-translate-y-1 transition">
            X
        </button>
    </form>

</aside>