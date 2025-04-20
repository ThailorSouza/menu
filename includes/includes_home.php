<?php
// Include this portion at the beginning to handle search functionality and initialize the cart.
session_start();
include_once '../config/database.php'; // Assuming database connection is here.
include_once '../functions/cart.php'; // Include cart helper functions.

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $searchTerm = filter_input(INPUT_POST, 'searchTerm', FILTER_SANITIZE_STRING);
    $searchQuery = "SELECT * FROM ws_itens WHERE nome_item LIKE :searchTerm";
    $lerbanco->FullRead($searchQuery, "searchTerm=%{$searchTerm}%");
    $searchResults = $lerbanco->getResult();
}
?>

<div class="search-section">
    <form method="POST" action="">
        <div class="input-group">
            <input type="text" name="searchTerm" class="form-control" placeholder="Search for a product..." required>
            <span class="input-group-btn">
                <button class="btn btn-primary" type="submit" name="search">Search</button>
            </span>
        </div>
    </form>
</div>

<?php if (isset($searchResults) && !empty($searchResults)): ?>
    <div class="search-results">
        <h3>Search Results:</h3>
        <ul class="list-group">
            <?php foreach ($searchResults as $item): ?>
                <li class="list-group-item">
                    <span><?= $item['nome_item']; ?></span> - 
                    <strong>Price:</strong> <?= number_format($item['preco_item'], 2); ?>
                    <form method="POST" action="includes/processAddToCart.php" style="display: inline;">
                        <input type="hidden" name="itemId" value="<?= $item['id']; ?>">
                        <input type="hidden" name="itemName" value="<?= $item['nome_item']; ?>">
                        <input type="hidden" name="itemPrice" value="<?= $item['preco_item']; ?>">
                        <button type="submit" class="btn btn-success btn-sm">Add to Cart</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php elseif(isset($searchTerm)): ?>
    <p>No products found for "<strong><?= htmlspecialchars($searchTerm); ?></strong>".</p>
<?php endif; ?>

<!-- Display Cart -->
<div class="cart-section">
    <h3>Your Cart:</h3>
    <?php if (!empty($_SESSION['cart'])): ?>
        <ul class="list-group">
            <?php foreach ($_SESSION['cart'] as $cartItem): ?>
                <li class="list-group-item">
                    <?= $cartItem['name']; ?> - 
                    <strong>Price:</strong> <?= $cartItem['price']; ?> x <?= $cartItem['quantity']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</div>